<?php

namespace App\Http\Controllers\V2;

use App\Domains\Auth\RoleTypes;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\CompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Domains\Enum\User\UserStageEnum;
use App\Exceptions\Company\CompanyAlreadyExistException;
use App\Exceptions\User\UserAlreadyExistException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\AddCompanyDetailsRequest;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\CreateCompanyUserRequest;
use App\Http\Requests\Company\UpdateCompanyUserRequest;
use App\Http\Requests\InviteUserRequest;
use App\Models\Company;
use App\Models\UserInvitation;
use App\Repositories\Contracts\AssetRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\UserRoleRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCompanyRepositoryInterface $userCompanyRepository,
        private readonly UserInvitationRepositoryInterface $userInvitationRepository,
        private readonly SSOServiceInterface $ssoService,
        private readonly UserRoleRepositoryInterface $userRoleRepository,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly AssetRepositoryInterface $assetRepository,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {
        Log::info('Company Registration Request Received', $request->all());

        try {
            $companyExist = $this->companyRepository->exist(CompanyConstant::EMAIL, $request->getCompanyDTO()->getEmail());

            throw_if($companyExist, CompanyAlreadyExistException::class);

            $userExist = $this->userRepository->exist(UserConstant::EMAIL, $request->getUserDTO()->getEmail());

            throw_if($userExist, UserAlreadyExistException::class);

            //Create Company on SSO
            $createSSOCompany = $this->ssoService->createSSOCompany($request->getSSODTO());

            if ($createSSOCompany->status() !== Response::HTTP_CREATED) {
                return $this->error(Response::HTTP_BAD_REQUEST, $createSSOCompany->json()['message']);
            }

            try {
                $dbData = DB::transaction(function () use ($request, $createSSOCompany) {
                    $tenant = $this->tenantRepository->create($request->getTenantDTO()->toArray());

                    $ssoData = $createSSOCompany->json()['data'];
                    $companyInvitationCode = Str::random(32);

                    $companyDto = $request->getCompanyDTO()
                                            ->setTenantId($tenant->id)
                                            ->setSsoId($ssoData['company_id'])
                                            ->setInvitationCode($companyInvitationCode);

                    $userDto = $request->getUserDTO()->setTenantId($tenant->id)->setSsoId($ssoData['user_id']);

                    $company = $this->companyRepository->create($companyDto->toArray());
                    $user = $this->userRepository->create($userDto->toArray());

                    $this->userCompanyRepository->create([
                        'tenant_id' => $tenant->id,
                        'company_id' => $company->id,
                        'user_id' => $user->id,
                        'status' => UserCompanyStatusEnum::ACTIVE->value,
                    ]);

                    //Assign admin role to user
                    $adminRole = $this->roleRepository->first('name', RoleTypes::ADMINISTRATOR);

                    $this->userRoleRepository->create([
                        UserRoleConstant::USER_ID => $user->id,
                        UserRoleConstant::COMPANY_ID => $company->id,
                        UserRoleConstant::ROLE_ID => $adminRole->id,
                    ]);

                    return [
                        'user' => $user,
                        'company' => $company,
                    ];
                });
            } catch (Exception $exception) {
                //operation failed on core, notify sso
                return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
            }

            $this->ssoService->createEmailOTP($dbData['user']->email);

            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $dbData);
        } catch (CompanyAlreadyExistException $exception) {
            return $exception->message();
        } catch (UserAlreadyExistException $exception) {
            return $exception->message();
        } catch (\ErrorException $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __($exception->getMessage()));
        } catch (Exception $exception) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }

    public function inviteCompanyUsers(InviteUserRequest $request, Company $company)
    {
        $user = $company->users[0];

        if ($user->stage == UserStageEnum::VERIFICATION->value || $user->stage == UserStageEnum::COMPANY_DETAILS || $user->stage == UserStageEnum::SUBSCRIPTION_PLAN) {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.wrong-user-stage'));
        }

        $DTOs = $request->getInvitationData($company->id, $user->id);

        foreach ($DTOs as $userDto) {
            $this->userInvitationRepository->inviteCompanyUser($userDto);
        }

        if ($user->stage == UserStageEnum::USERS->value) {
            $this->userRepository->updateById($user->id, [
                'stage' => UserStageEnum::COMPLETED->value,
            ]);
        }

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully invited users',
        );
    }

    public function addCompanyDetails(AddCompanyDetailsRequest $request, Company $company)
    {
        if (!isset($company->users[0])) {
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }

        $user = $company->users[0];

        if ($user->stage == UserStageEnum::VERIFICATION->value) {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.error-verify-account'));
        }

        $dto = $request->getDTO();

        $resp = $this->ssoService->updateCompany($dto, $company->sso_id);

        if ($resp->status() != Response::HTTP_OK) {
            return $this->error(Response::HTTP_BAD_REQUEST, $resp->json()['message']);
        }

        $company->update($dto->toArray());
        if ($user->stage == UserStageEnum::COMPANY_DETAILS->value) {
            $user->update(['stage' => UserStageEnum::SUBSCRIPTION_PLAN->value]);
        }

        return $this->response(Response::HTTP_OK, __('messages.company-updated'));
    }

    public function soleAdminUser(Company $company)
    {
        $user = $company->users[0];

        if ($user->stage == UserStageEnum::COMPLETED->value) {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.onboarding-already-completed'));
        }

        if ($user->stage != UserStageEnum::USERS->value) {
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.wrong-user-stage'));
        }

        $this->userRepository->updateById($user->id, [
            'stage' => UserStageEnum::COMPLETED->value,
        ]);

        return $this->response(Response::HTTP_CREATED, __('messages.company-sole-admin'));
    }

    public function getCompanyUsers(Company $company)
    {
        $users = $company->users;

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $users);
    }

    public function addCompanyUser(CreateCompanyUserRequest $request, Company $company)
    {
        $user = $request->user();
        $code = (string) Str::uuid();

        $dto = $request->getDTO();

        $dto->setCompanyId($company->id)
            ->setInvitedBy($user->id)
            ->setCode($code);

        $this->userInvitationRepository->create($dto->toArray());

        return $this->response(Response::HTTP_CREATED, __('messages.record-created'));
    }

    public function deleteCompanyUser(Company $company, UserInvitation $userInvitation){
        $this->userInvitationRepository->deleteById($userInvitation->id);

        return $this->response(Response::HTTP_OK, __('messages.record-deleted'), );
    }

    public function updateCompanyUser(UpdateCompanyUserRequest $request, Company $company, UserInvitation $userInvitation)
    {
        $dto = $request->getDTO();

        $this->userInvitationRepository->updateById($userInvitation->id, $dto->toSynthensizedArray());

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), );
    }

    public function getUserInvitationLink(Company $company)
    {
        $link = sprintf('%s/%s', getenv('CORE_COMPANY_USER_INVITATION_URL'), $company[CompanyConstant::INVITATION_CODE]);

        return $this->response(Response::HTTP_OK, __('messages.record-updated'), ['link' => $link]);
    }

    public function getCompanyUserDetails(Request $request, Company $company, UserInvitation $userInvitation){
        $user = $this->userRepository->first(UserConstant::EMAIL, $userInvitation->email);

        $assets = $this->assetRepository->get(AssetConstant::ASSIGNED_TO, $user->id);

        $data = [
            'details' => $userInvitation,
            'assets' => $assets
        ];

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $data);
    }
}
