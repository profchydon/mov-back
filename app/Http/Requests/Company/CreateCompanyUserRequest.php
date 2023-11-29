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
            'name' => 'nullable|string',
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
            ->setJobTitle($this->input('job_title', ''))
            ->setEmploymentType($this->input('employment_type', ''))
            ->setRoleId($this->input('role_id'))
            ->setOfficeId($this->input('office_id', ''))
            ->setDepartmentId($this->input('department_id', ''))
            ->setTeamId($this->input('team_id', ''));

        return $dto;
    }
}
