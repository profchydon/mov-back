<?php

namespace App\Repositories;

use App\Domains\DTO\AssignUserRoleDTO;
use App\Models\UserRole;
use App\Repositories\Contracts\UserRoleRepositoryInterface;

class UserRoleRepository extends BaseRepository implements UserRoleRepositoryInterface
{
    public function model(): string
    {
        return UserRole::class;
    }

    public function assignUserRole(AssignUserRoleDTO $assignUserRoleDTO)
    {
    }
}
