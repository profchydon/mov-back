<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Rules\HumanNameRule;
use App\Rules\StateExistsInCountry;
use App\Rules\ValidLatitude;
use App\Rules\ValidLongitude;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCompanyOfficeRequest extends FormRequest
{
    public function rules(): array
    {
        $company = $this->route('company');
        $country = $this->input('country');

        return [
            'name' => ['required', new HumanNameRule(), Rule::unique('offices', 'name')->where('company_id', $company->id)],
            'street_address' => 'required|string|min:5',
            'country' => ['required', Rule::exists('countries', 'name')],
            'currency_code' => ['required', Rule::exists('currencies', 'code')],
            'state' => ['required', new StateExistsInCountry($country)],
            'latitude' => ['required', new ValidLatitude()],
            'longitude' => ['required', new ValidLongitude()],
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
