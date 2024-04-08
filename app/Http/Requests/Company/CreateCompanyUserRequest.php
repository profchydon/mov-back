<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\CreateCompanyUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompanyUserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'job_title' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'office_id' => ['nullable', Rule::exists('offices', 'id')],
            'department_id' => ['nullable', Rule::exists('departments', 'id')],
            'team_id' => ['nullable', Rule::exists('teams', 'id')],
        ];
    }

    /**
     * @return CreateCompanyUserDTO
     */
    public function getDTO(): CreateCompanyUserDTO
    {
        $dto = new CreateCompanyUserDTO();

        $dto->setEmail($this->input('email'))
            ->setFirstName($this->input('first_name'))
            ->setLastName($this->input('last_name'))
            ->setJobTitle($this->input('job_title', null))
            ->setEmploymentType($this->input('employment_type', null))
            ->setRoleId($this->input('role_id'))
            ->setOfficeId($this->input('office_id', null))
            ->setDepartmentId($this->input('department_id', null))
            ->setTeamId($this->input('team_id', null))
            ->setAllowUserLogin($this->input('allow_user_login', true));

        return $dto;
    }
}
