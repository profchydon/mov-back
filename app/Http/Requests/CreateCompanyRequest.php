<?php

namespace App\Http\Requests;

use App\Domains\DTO\CreateCompanyDTO;
use App\Domains\DTO\CreateTenantDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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

    public function getCompanyDTO(): CreateCompanyDTO
    {
        $dto = new CreateCompanyDTO();
        $dto->setName($this->name)
            ->setSize($this->size)
            ->setIndustry($this->industry)
            ->setAddress($this->address)
            ->setCountry($this->country)
            ->setState($this->state);

        return $dto;
    }

    public function getTenantDTO(): CreateTenantDTO
    {
        $dto = new CreateTenantDTO();
        $dto->setName($this->name);

        return $dto;
    }
}
