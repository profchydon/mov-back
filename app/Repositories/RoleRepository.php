<?php

namespace App\Repositories;

use App\Domains\Constant\CommonConstant;
use App\Domains\DTO\CreateUserRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function model(): string
    {
        return Role::class;
    }

    public function createRole(CreateUserRoleDTO $dto): Role
    {
        $role = Role::create($dto->toArray());
        $permissions = Permission::whereIn('id', $dto->getPermissions())->get();

        $role->syncPermissions($permissions);

        return $role;
    }

    public function isRoleExists(string $name, string $companyId)
    {
        return $role = Role::where('name', $name)->where(CommonConstant::COMPANY_ID, $companyId)->first();

        if($role != null){
            return true;
        }

        return false;
    }
}
