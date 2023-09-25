<?php

namespace App\Http\Controllers\v2;

use Exception;
use App\Models\Company;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Domains\Enum\User\UserStageEnum;
use App\Http\Requests\InviteUserRequest;
use App\Domains\Constant\CompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Exceptions\Company\CompanyAlreadyExistException;
use App\Exceptions\User\UserAlreadyExistException;
use App\Repositories\Contracts\TenantRepositoryInterface;
use App\Repositories\Contracts\CompanyRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;

class CompanyController extends Controller
{
    public function __construct(
        private readonly TenantRepositoryInterface $tenantRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCompanyRepositoryInterface $userCompanyRepository,
        private readonly UserInvitationRepositoryInterface $userInvitationRepository,
        private readonly SSOServiceInterface $ssoService
    ) {
    }

    public function create(CreateCompanyRequest $request): JsonResponse
    {

        try {

            $companyExist = $this->companyRepository->exist(CompanyConstant::EMAIL, $request->getCompanyDTO()->getEmail());

            throw_if($companyExist, CompanyAlreadyExistException::class);

            $userExist = $this->userRepository->exist(UserConstant::EMAIL, $request->getUserDTO()->getEmail());

            throw_if($userExist, UserAlreadyExistException::class);

            //Create Company on SSO
            $createSSOCompany = $this->ssoService->createSSOCompany($request->getSSODTO());

            $company = DB::transaction(function () use ($request) {

                $user = $this->userRepository->first(UserConstant::EMAIL, $request->getUserDTO()->getEmail());

                if ($user && $user->stage != UserStageEnum::COMPANY_DETAILS->value) {
                    return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
                }

                $tenant = $this->tenantRepository->create($request->getTenantDTO()->toArray());
                $companyDto = $request->getCompanyDTO()->setTenantId($tenant->id);
                $userDto = $request->getUserDTO()->setTenantId($tenant->id);
                $company = $this->companyRepository->create($companyDto->toArray());
                $user = $this->userRepository->create($userDto->toArray());

                $this->userCompanyRepository->create([
                    'tenant_id' => $tenant->id,
                    'company_id' => $company->id,
                    'user_id' => $user->id,
                    'status' => UserCompanyStatusEnum::ACTIVE->value
                ]);

                $this->userRepository->updateById($user->id, [
                    'stage' => UserStageEnum::USERS->value
                ]);

                return $company;
            });

            return $this->response(Response::HTTP_CREATED, __('messages.record-created'), $company);

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
        $user = $this->userRepository->first('id', '9a320b0d-cb24-4cf9-b6de-f77407fde3ae'); //this is only temporary till we finish up auth

        if ($user->stage != UserStageEnum::USERS->value) {
            return $this->error(Response::HTTP_BAD_REQUEST, 'Make sure you complete previous steps');
        }

        $DTOs = $request->getInvitationData($company->id, $user->id);
        $this->userInvitationRepository->inviteCompanyUsers($DTOs);

        return $this->response(
            Response::HTTP_CREATED,
            'You have successfully invited users',
        );
    }
}
