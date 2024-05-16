<?php

namespace App\Repositories;

use App\Domains\Auth\RoleTypes;
use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Constant\UserDepartmentConstant;
use App\Domains\Constant\UserRoleConstant;
use App\Domains\Constant\UserTeamConstant;
use App\Domains\Enum\User\UserCompanyStatusEnum;
use App\Models\Company;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserDepartment;
use App\Models\UserInvitation;
use App\Models\UserRole;
use App\Models\UserTeam;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function model(): string
    {
        return User::class;
    }

    /**
     * Create a user company relationship.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param $role The role object.
     * @return void
     */
    public function createUserCompany(Company $company, User $user, $role): UserCompany
    {

        // Determine the has_seat value based on the role type
        $hasSeat = $role->name === RoleTypes::BASIC->value ? false : true;

        // Create the user company record
        return UserCompany::updateOrCreate(
            [
                UserCompanyConstant::COMPANY_ID => $company->id,
                UserCompanyConstant::TENANT_ID => $company->tenant_id,
                UserCompanyConstant::USER_ID => $user->id,
            ],
            [
                UserCompanyConstant::TENANT_ID => $company->tenant_id,
                UserCompanyConstant::COMPANY_ID => $company->id,
                UserCompanyConstant::USER_ID => $user->id,
                UserCompanyConstant::STATUS => UserCompanyStatusEnum::ACTIVE->value,
                UserCompanyConstant::HAS_SEAT => $hasSeat,
            ]
        );
    }

    /**
     * Assigns a role to a user for a specific company.
     *
     * @param Company $company The company to assign the role to.
     * @param User $user The user to assign the role to.
     * @param $role The role to assign.
     * @return void
     */
    public function assignRoleToUser(Company $company, User $user, $role): UserRole
    {
        // Create a new user role record with the given user, company, and role IDs.
        return UserRole::updateOrCreate([
            UserCompanyConstant::USER_ID => $company->id,
            UserCompanyConstant::COMPANY_ID => $user->id,
            UserRoleConstant::ROLE_ID => $role->id,
        ], [
            UserRoleConstant::USER_ID => $user->id,
            UserRoleConstant::COMPANY_ID => $company->id,
            UserRoleConstant::ROLE_ID => $role->id,
        ]);
    }

    /**
     * Creates a user department.
     *
     * This method creates a new user department record in the database.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param Department $department The department object.
     * @return UserDepartment The created user department object.
     */
    public function createUserDepartment(Company $company, User $user, Department|string $department = null): UserDepartment
    {

        if (!($department instanceof Department)) {
            $department = Department::findOrFail($department);
        }

        // Create a new user department record in the database
        return UserDepartment::create([
            UserDepartmentConstant::USER_ID => $user->id, // The ID of the user to assign the department to.
            UserDepartmentConstant::COMPANY_ID => $company->id, // The ID of the company the user is assigned to.
            UserDepartmentConstant::DEPARTMENT_ID => $department->id, // The ID of the department to assign the user to.
        ]);
    }

    /**
     * Creates a user team.
     *
     * This method creates a new user team record in the database.
     *
     * @param Company $company The company object.
     * @param User $user The user object.
     * @param Department $invitation The user invitation object.
     * @param Team $team The team object.
     * @return UserTeam The created user team object.
     */
    public function createUserTeam(Company $company, User $user, Department|string $department, Team|string $team): UserTeam
    {

        if (!($department instanceof Department)) {
            $department = Department::findOrFail($department);
        }

        if (!($team instanceof Team)) {
            $team = Department::findOrFail($team);
        }

        // Create the user team using the repository
        return UserTeam::create([
            UserTeamConstant::USER_ID => $user->id, // The ID of the user to assign the team to.
            UserTeamConstant::COMPANY_ID => $company->id, // The ID of the company the user is assigned to.
            UserTeamConstant::DEPARTMENT_ID => $department->id, // The ID of the department the user is assigned to.
            UserTeamConstant::TEAM_ID => $team->id, // The ID of the team to assign the user to.
        ]);
    }
}
