<?php

namespace App\Http\Requests;

use App\Domains\Auth\PermissionTypes;
use App\Domains\DTO\CreateUserRoleDTO;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        /**
         * @var User
         */
        $user = auth()->user();

        return $user->hasAnyPermission([PermissionTypes::ROLE_FULL_ACCESS->value, PermissionTypes::ROLE_CREATE_ACCESS->value]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string',Rule::unique('roles', 'name')],
            'permissions' => 'required|array',
            'permissions.*' => 'integer',
        ];
    }

    public function getDTO(): CreateUserRoleDTO
    {
        $dto = new CreateUserRoleDTO();

        $dto->setName($this->input('name'))
            ->setPermissions($this->input('permissions'))
            ->setDescription($this->input('description'));

        return $dto;
    }
}
