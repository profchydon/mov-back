<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Rules\HumanNameRule;
use App\Rules\StateExistsInCountry;
use App\Rules\ValidLatitude;
use App\Rules\ValidLongitude;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyOfficeRequest extends FormRequest
{
    public function rules(): array
    {
        $company = $this->route('company');
        $country = $this->input('country');
        $office = $this->route('office');

        return [
            'name' => ['sometimes', new HumanNameRule(), Rule::unique('offices', 'name')->where('company_id', $company->id)->ignore($office->id)],
            'street_address' => 'required|string|min:5',
            'country' => ['sometimes', Rule::exists('countries', 'name')],
            'currency_code' => ['sometimes', Rule::exists('currencies', 'code')],
            'state' => ['sometimes', new StateExistsInCountry($country)],
            'latitude' => ['sometimes', new ValidLatitude()],
            'longitude' => ['sometimes', new ValidLongitude()],
        ];
    }

    public function companyOfficeDTO(): CreateCompanyOfficeDTO
    {
        $company = $this->route('company');

        $dto = new CreateCompanyOfficeDTO();
        $dto->setName($this->input('name'))
            ->setStreetAddress($this->input('street_address'))
            ->setState($this->input('state'))
            ->setCountry($this->input('country'))
            ->setLongitude($this->input('longitude'))
            ->setLatitude($this->input('latitude'))
            ->setCurrencyCode($this->input('currency_code'))
            ->setCompanyId($company->id)
            ->setTenantId($company->tenant_id);

        return $dto;
    }
}
