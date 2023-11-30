<?php

namespace App\Repositories;

use App\Domains\Constant\CommonConstant;
use App\Domains\DTO\CreateUserRoleDTO;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function model(): string
    {
        return Role::class;
    }

    public function getCompanyRoles(string $companyId)
    {
        $roles = Role::where(CommonConstant::COMPANY_ID, $companyId)->orWhere(CommonConstant::COMPANY_ID, null)->orderBy('name', 'ASC')->get();

        return $roles;
    }

    public function createRole(CreateUserRoleDTO $dto): Role
    {
        $data = array_merge(['guard_name' => 'web'], $dto->toArray());

        $role = Role::create($data);
        $permissions = Permission::whereIn('id', $dto->getPermissions())->get();

        $role->syncPermissions($permissions);

        return $role;
    }

    public function isRoleExists(string $name, string $companyId)
    {
        return $role = Role::where('name', $name)->where(CommonConstant::COMPANY_ID, $companyId)->first();

        if ($role != null) {
            return true;
        }

        return false;
    }

    public function updateRole(CreateUserRoleDTO $dto, Role|string $role)
    {
        if(!($role instanceof Role)){
            $role = Role::findById($role);
        }

        $role->update([
            'name' => $dto->getName()
        ]);

        $permissions = Permission::whereIn('id', $dto->getPermissions())->get();
        $role->syncPermissions($permissions);
    }
}
