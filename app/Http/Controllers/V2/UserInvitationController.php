<?php

namespace App\Http\Controllers\V2;

use App\Domains\Auth\RoleTypes;
use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Constant\UserDepartmentConstant;
use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Constant\UserTeamConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Domains\Enum\User\UserInvitationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AcceptUserInvitationRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserDepartmentRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\UserRoleRepositoryInterface;
use App\Repositories\Contracts\UserTeamRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserInvitationController extends Controller
{
    /**
     * @param UserInvitationRepositoryInterface $userInvitationRepository
     */
    public function __construct(
        private readonly UserInvitationRepositoryInterface $userInvitationRepository,
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserCompanyRepositoryInterface $userCompanyRepository,
        private readonly SSOServiceInterface $ssoService,
        private readonly UserRoleRepositoryInterface $userRoleRepository,
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly UserDepartmentRepositoryInterface $userDepartmentRepository,
        private readonly UserTeamRepositoryInterface $userTeamRepository,
    ) {
    }

    public function findUserInvitation($code)
    {
        $invitation = $this->userInvitationRepository->firstWithRelation(UserInvitationConstant::CODE, $code, ['role']);

        if (!$invitation) {
            return $this->error(Response::HTTP_NOT_FOUND, __('messages.invite-not-found'));
        }

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $invitation);
    }

    public function acceptUserInvitation($code, AcceptUserInvitationRequest $request)
    {
        $invitation = $this->userInvitationRepository->first(UserInvitationConstant::CODE, $code);

        if (!$invitation) {
            return $this->error(Response::HTTP_NOT_FOUND, __('messages.invite-not-found'));
        }

        try {
            $userDto = $request->getSSOUserDTO();

            $company = $invitation->company;

            $createSSOUser = $this->ssoService->createSSOUser($userDto, $company->sso_id);

            if ($createSSOUser->status() !== Response::HTTP_CREATED) {
                return $this->error(Response::HTTP_BAD_REQUEST, $createSSOUser->json()['message']);
            }

            $dbData = DB::transaction(function () use ($request, $createSSOUser, $company, $code, $invitation) {
                $ssoData = $createSSOUser->json()['data'];

                $userDto = $request->getUserDTO()
                    ->setEmploymentType($invitation->employment_type, null)
                    ->setOfficeId($invitation->office_id, null)
                    ->setTenantId($company->tenant_id)
                    ->setSsoId($ssoData['id']);

                $user = $this->userRepository->create($userDto->toArray());
                $role = $invitation->role;

                $this->userCompanyRepository->create([
                    UserCompanyConstant::TENANT_ID => $company->tenant_id,
                    UserCompanyConstant::COMPANY_ID => $company->id,
                    UserCompanyConstant::USER_ID => $user->id,
                    UserCompanyConstant::STATUS => UserCompanyStatusEnum::ACTIVE->value,
                    UserCompanyConstant::HAS_SEAT => $role->name === RoleTypes::BASIC->value ? false : true,
                ]);

                //Assign role to user
                $this->userRoleRepository->create([
                    UserRoleConstant::USER_ID => $user->id,
                    UserRoleConstant::COMPANY_ID => $company->id,
                    UserRoleConstant::ROLE_ID => $invitation->role_id,
                ]);

                if ($invitation->department_id !== null) {
                    $this->userDepartmentRepository->create([
                        UserDepartmentConstant::USER_ID => $user->id,
                        UserDepartmentConstant::COMPANY_ID => $company->id,
                        UserDepartmentConstant::DEPARTMENT_ID => $invitation->department_id,
                    ]);

                    if ($invitation->team_id !== null) {
                        $this->userTeamRepository->create([
                            UserTeamConstant::USER_ID => $user->id,
                            UserTeamConstant::COMPANY_ID => $company->id,
                            UserTeamConstant::DEPARTMENT_ID => $invitation->department_id,
                            UserTeamConstant::TEAM_ID => $invitation->team_id,
                        ]);
                    }
                }

                $this->userInvitationRepository->update(
                    UserInvitationConstant::CODE,
                    $code,
                    [UserInvitationConstant::STATUS => UserInvitationStatusEnum::ACCEPTED]
                );

                return [
                    'user' => $user,
                    'company' => $company,
                ];
            });

            return $this->response(Response::HTTP_OK, __('messages.record-created'), $dbData);
        } catch (Exception $exception) {
            //operation failed on core, notify sso
            return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY, __('messages.error-encountered'));
        }
    }
}
