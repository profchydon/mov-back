<?php

namespace App\Http\Requests;

use App\Domains\Auth\PermissionTypes;
use App\Domains\DTO\CreateUserRoleDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = auth()->user();
        $permissionsList = $user->roles()->with('permissions')->get()->pluck('permissions')->flatten(1);

        return $permissionsList->contains('name', PermissionTypes::ROLE_FULL_ACCESS)
            || $permissionsList->contains('name', PermissionTypes::ROLE_CREATE_ACCESS);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ];
    }

    public function getDTO(): CreateUserRoleDTO
    {
        $dto = new CreateUserRoleDTO();

        $dto->setName($this->input('name'))
            ->setPermissions($this->input('permissions'));

        return $dto;
    }
}
