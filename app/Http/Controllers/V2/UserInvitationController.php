<?php

namespace App\Http\Controllers\V2;

use App\Common\SubscriptionValidator;
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
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInvitation;
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

    /**
     * Find a user invitation by code.
     *
     * @param string $code The code of the invitation.
     * @throws \Some_Exception_Class If the invitation is not found.
     * @return \Some_Return_Value The fetched user invitation.
     */
    public function findUserInvitation($code)
    {
        $invitation = $this->userInvitationRepository->firstWithRelation(UserInvitationConstant::CODE, $code, ['role']);

        if (!$invitation) {
            return $this->error(Response::HTTP_NOT_FOUND, __('messages.invite-not-found'));
        }

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $invitation);
    }

    /**
     * Accepts a user invitation with the given code and request.
     *
     * @param string $code The invitation code
     * @param AcceptUserInvitationRequest $request The accept user invitation request
     * @throws Exception If an error occurs during the acceptance process
     * @return Response The response containing the created record data
     */
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

                // Check available seats
                if (!$this->hasAvailableSeats($company, $role)) {
                    $role = $this->roleRepository->first('name', RoleTypes::BASIC->value);
                }

                $this->createUserCompany($company, $user, $role);
                $this->assignRoleToUser($company, $user, $role);


                if ($invitation->department_id !== null) {
                    $this->createUserDepartment($company, $user, $invitation);

                    if ($invitation->team_id !== null) {
                        $this->createUserTeam($company, $user, $invitation);
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

    /**
     * Checks if the company has available seats for a given role.
     *
     * @param Company $company The company name.
     * @param $role The role to check.
     * @return bool True if the company has available seats or the role is basic, false otherwise.
     */
    private function hasAvailableSeats(Company $company, Role $role): bool
    {
        // Create a SubscriptionValidator instance for the company
        $subscriptionValidator = new SubscriptionValidator($company);

        // Check if the company has available seats
        $hasAvailableSeats = $subscriptionValidator->hasAvailableSeats();

        // Check if the role is basic
        $isBasicRole = $role->name === RoleTypes::BASIC->value;

        // Return true if the company has available seats or the role is basic
        return $hasAvailableSeats || $isBasicRole;
    }

    /**
     * Create a user company relationship.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param $role The role object.
     * @return void
     */
    private function createUserCompany(Company $company, User $user, $role): void
    {
        // Determine the has_seat value based on the role type
        $hasSeat = $role->name === RoleTypes::BASIC->value ? false : true;

        // Create the user company record
        $this->userCompanyRepository->create([
            UserCompanyConstant::TENANT_ID => $company->tenant_id,
            UserCompanyConstant::COMPANY_ID => $company->id,
            UserCompanyConstant::USER_ID => $user->id,
            UserCompanyConstant::STATUS => UserCompanyStatusEnum::ACTIVE->value,
            UserCompanyConstant::HAS_SEAT => $hasSeat,
        ]);
    }

    /**
     * Assigns a role to a user for a specific company.
     *
     * @param Company $company The company to assign the role to.
     * @param User $user The user to assign the role to.
     * @param $role The role to assign.
     * @return void
     */
    private function assignRoleToUser(Company $company, User $user, $role): void
    {
        // Create a new user role record with the given user, company, and role IDs.
        $this->userRoleRepository->create([
            UserRoleConstant::USER_ID => $user->id,
            UserRoleConstant::COMPANY_ID => $company->id,
            UserRoleConstant::ROLE_ID => $role->id,
        ]);
    }

    /**
     * Create a user department.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param UserInvitation $invitation The user invitation object.
     * @return void
     */
    private function createUserDepartment(Company $company, User $user, UserInvitation $invitation): void
    {
        // Create a new user department record in the database
        $this->userDepartmentRepository->create([
            UserDepartmentConstant::USER_ID => $user->id,
            UserDepartmentConstant::COMPANY_ID => $company->id,
            UserDepartmentConstant::DEPARTMENT_ID => $invitation->department_id,
        ]);
    }

    /**
     * Creates a user team.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param UserInvitation $invitation The user invitation object.
     * @return void
     */
    private function createUserTeam(Company $company, User $user, UserInvitation $invitation): void
    {
        // Create the user team using the repository
        $this->userTeamRepository->create([
            UserTeamConstant::USER_ID => $user->id,
            UserTeamConstant::COMPANY_ID => $company->id,
            UserTeamConstant::DEPARTMENT_ID => $invitation->department_id,
            UserTeamConstant::TEAM_ID => $invitation->team_id,
        ]);
    }
}
