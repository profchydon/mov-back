<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\CreateCompanyUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyUserRequest extends FormRequest
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
            'name' => 'optional|string',
            'email' => 'optional|email',
            'job_title' => 'optional|string',
            'employment_type' => 'optional|string',
            'role_id' => ['optional', Rule::exists('roles', 'id')],
            'office_id' => ['optional', Rule::exists('offices', 'id')],
            'department_id' => ['optional', Rule::exists('departments', 'id')],
            'team_id' => ['optional', Rule::exists('teams', 'id')],
        ];
    }

    /**
     * @return CreateCompanyUserDTO
     */
    public function getDTO(): CreateCompanyUserDTO
    {
        $dto = new CreateCompanyUserDTO();

        $dto->setName($this->input('name'))
            ->setEmail($this->input('email'))
            ->setJobTitle($this->input('job_title'))
            ->setEmploymentType($this->input('employment_type'))
            ->setRoleId($this->input('role_id'))
            ->setOfficeId($this->input('office_id'))
            ->setDepartmentId($this->input('department_id'))
            ->setTeamId($this->input('team_id'));

        return $dto;
    }
}
