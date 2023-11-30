<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\UpdateCompanyUserDTO;
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
            // 'name' => 'optional|string',
            // 'email' => 'optional|email',
            'job_title' => 'nullable|string',
            'employment_type' => 'nullable|string',
            'office_id' => ['nullable', Rule::exists('offices', 'id')],
            'roles' => ['nullable', Rule::exists('roles', 'id')],
            'departments' => ['nullable', 'array', Rule::exists('departments', 'id')],
            'teams' => ['nullable', 'array', Rule::exists('teams', 'id')],
        ];
    }

    /**
     * @return UpdateCompanyUserDTO
     */
    public function getDTO(): UpdateCompanyUserDTO
    {
        $dto = new UpdateCompanyUserDTO();

        $dto
            // ->setName($this->input('name'))
            // ->setEmail($this->input('email'))
            ->setJobTitle($this->input('job_title'))
            ->setEmploymentType($this->input('employment_type'))
            ->setRoles($this->input('roles'))
            ->setOfficeId($this->input('office_id'))
            ->setDepartments($this->input('departments'))
            ->setTeams($this->input('teams'));

        return $dto;
    }
}
