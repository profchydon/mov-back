<?php

namespace App\Http\Controllers\V2;

use App\Domains\Constant\UserInvitationConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Domains\Enum\User\UserInvitationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\AcceptUserInvitationRequest;
use App\Models\UserInvitation;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserCompanyRepositoryInterface;
use App\Repositories\Contracts\UserInvitationRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\UserRoleRepositoryInterface;
use App\Services\Contracts\SSOServiceInterface;
use Exception;
use Illuminate\Http\Request;
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
    ) {
    }

    public function findUserInvitation($code)
    {
        $invitation = $this->userInvitationRepository->first(UserInvitationConstant::CODE, $code);

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

                $userDto = $request->getUserDTO()->setTenantId($company->tenant_id)->setSsoId($ssoData['id']);

                $user = $this->userRepository->create($userDto->toArray());

                $this->userCompanyRepository->create([
                    'tenant_id' => $company->tenant_id,
                    'company_id' => $company->id,
                    'user_id' => $user->id,
                    'status' => UserCompanyStatusEnum::ACTIVE->value,
                ]);

                //Assign role to user
                $role = $this->roleRepository->first('id', $invitation->role_id);

                $this->userRoleRepository->create([
                    UserRoleConstant::USER_ID => $user->id,
                    UserRoleConstant::COMPANY_ID => $company->id,
                    UserRoleConstant::ROLE_ID => $role->id,
                ]);

                $this->userInvitationRepository->update(UserInvitationConstant::CODE, $code,
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
