<?php

namespace App\Http\Requests;

use App\Domains\DTO\CreateUserRoleDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'permissions' => 'required|array',
            'permissions.*' => 'integer'
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
