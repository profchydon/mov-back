<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\AssignUserRoleDTO;

interface UserRoleRepositoryInterface extends BaseRepositoryInterface
{
    public function assignUserRole(AssignUserRoleDTO $assignUserRoleDTO);
}
