<?php

namespace App\Http\Requests\Company;

use App\Domains\DTO\AddCompanyDetailsDTO;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|string',
            'size' => 'required|string',
            'industry' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'state' => 'required|string',
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
}
