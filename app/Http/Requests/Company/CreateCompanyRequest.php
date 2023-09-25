<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\CreateCompanyDTO;
use App\Domains\DTO\CreateSSOCompanyDTO;
use App\Domains\DTO\CreateTenantDTO;
use App\Domains\DTO\CreateUserDTO;
use App\Rules\HumanNameRule;
use App\Rules\RaydaStandardPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company' => 'required|array',
            'company.name' => 'required|string',
            'company.email' => 'required|email|unique:companies,email',
            'user' => 'required|array',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => ['required', new RaydaStandardPasswordRule()],
            'user.first_name' => ['required', new HumanNameRule()],
            'user.last_name' => ['required', new HumanNameRule()]
        ];
    }

    public function getUserDTO(): CreateUserDTO
    {
        $dto = new CreateUserDTO();
        $dto->setFirstName($this->input('user.first_name'))
            ->setLastName($this->input('user.last_name'))
            ->setPassword($this->input('user.password'))
            ->setEmail($this->input('company.email'));

        return $dto;
    }

    public function getCompanyDTO(): CreateCompanyDTO
    {
        $dto = new CreateCompanyDTO();
        $dto->setName($this->input('company.name', ''))
            ->setEmail($this->input('company.email', ''))
            ->setPhone($this->input('company.phone', ''))
            ->setIndustry('Health'); //Please remove this line later

        return $dto;
    }

    public function getTenantDTO(): CreateTenantDTO
    {
        $dto = new CreateTenantDTO();
        $dto->setName($this->input('company.name', ''));

        return $dto;
    }

    public function getSSODTO() : CreateSSOCompanyDTO {
        $dto = new CreateSSOCompanyDTO();
        $dto->setUser($this->getUserDTO());
        $dto->setCompany($this->getCompanyDTO());

        return $dto;
    }
}
