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
            'name' => 'required|string',
            'email' => 'required|email',
            'job_title' => 'required|string',
            'employment_type' => 'required|string',
            'role_id' => ['required', Rule::exists('roles', 'id')],
            'office_id' => ['required', Rule::exists('offices', 'id')],
            'department_id' => ['required', Rule::exists('departments', 'id')],
            'team' => 'optional|string'
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
            ->setTeam($this->input('team'));

        return $dto;
    }
}
