<?php

namespace App\Repositories\Contracts;

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

interface UserRepositoryInterface extends BaseRepositoryInterface
{

    public function createUserCompany(Company $company, User $user, $role): UserCompany;

    public function assignRoleToUser(Company $company, User $user, $role): UserRole;

    public function createUserDepartment(Company $company, User $user, Department|string $department): UserDepartment;

    public function createUserTeam(Company $company, User $user, Department|string $department, Team|string $team): UserTeam;
}
