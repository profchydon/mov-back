<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRoleRequest;
use App\Models\Company;
use App\Repositories\Contracts\PermissionRepositoryInterface;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct(
        private readonly RoleRepositoryInterface $roleRepository,
        private readonly PermissionRepositoryInterface $permissionRepository
    ) {
    }

    public function fetchUserRoles(Company $company)
    {
        $roles = $this->roleRepository->getCompanyRoles($company->id);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $roles);
    }

    public function fetchPermissions()
    {
        $permissions = $this->permissionRepository->all();

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $permissions);
    }

    public function createUserRole(CreateUserRoleRequest $request, Company $company)
    {
        $dto = $request->getDTO();

        $dto->setCompanyId($company->id);

        if($this->roleRepository->isRoleExists($dto->getName(), $dto->getCompanyId())){
            return $this->error(Response::HTTP_BAD_REQUEST, __('messages.role-exists'));
        }

        $role = $this->roleRepository->createRole($dto);

        return $this->response(Response::HTTP_CREATED, __('messages.role.created'), $role);
    }
}
