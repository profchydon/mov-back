<?php

namespace App\Http\Requests\User;

use App\Domains\DTO\AssignUserRoleDTO;
use App\Domains\Enum\User\UserRoleStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', Rule::exists('users', 'id')],
            'company_id' => ['required', Rule::exists('companies', 'id')],
            'role_id' => ['required', Rule::exists('roles', 'id')],
        ];
    }

    public function getUserRoleDto(): AssignUserRoleDTO
    {
        $dto = new AssignUserRoleDTO();
        $dto->setUser($this->user)
            ->setCompany($this->company_id)
            ->setRole($this->role_id)
            ->setOffice($this->office_id, '')
            ->setStatus($this->status, UserRoleStatusEnum::ACTIVE->value);

        return $dto;
    }
}
