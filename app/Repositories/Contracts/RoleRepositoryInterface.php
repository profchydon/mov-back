<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateUserRoleDTO;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getCompanyRoles(string $companyId);

    public function createRole(CreateUserRoleDTO $dto): Role;

    public function isRoleExists(string $name, string $companyId);
}
