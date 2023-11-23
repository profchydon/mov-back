<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\AddCompanyDetailsDTO;
use App\Domains\DTO\CreateCompanyOfficeDTO;
use App\Rules\StateExistsInCountry;
use App\Rules\ValidLatitude;
use App\Rules\ValidLongitude;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddCompanyDetailsRequest extends FormRequest
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
        $country = $this->input('country');

        return [
            'name' => 'required|string',
            'size' => 'required|string',
            'industry' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'currency_code' => ['required', Rule::exists('currencies', 'code')],
            'state' => ['required', new StateExistsInCountry($country)],
            'latitude' => ['required', new ValidLatitude()],
            'longitude' => ['required', new ValidLongitude()],
        ];
    }

    public function getDTO(): AddCompanyDetailsDTO
    {
        $dto = new AddCompanyDetailsDTO();

        $dto->setName($this->input('name'))
            ->setSize($this->input('size'))
            ->setIndustry($this->input('industry'))
            ->setAddress($this->input('address'))
            ->setCountry($this->input('country'))
            ->setState($this->input('state'));

        return $dto;
    }

    public function companyOfficeDTO(): CreateCompanyOfficeDTO
    {
        $company = $this->route('company');

        $dto = new CreateCompanyOfficeDTO();
        $officeName = sprintf('%s %s', $this->input('name'), ' HQ');

        $dto->setName($officeName)
            ->setStreetAddress($this->input('address'))
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
