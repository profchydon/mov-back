<?php

namespace App\Http\Requests;

use App\Domains\DTO\CreateVendorDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateVendorRequest extends FormRequest
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
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ];
    }

    public function getDTO(): CreateVendorDTO
    {
        $dto = new CreateVendorDTO();

        $dto->setName($this->input('name'))
            ->setEmail($this->input('email'))
            ->setPhone($this->input('phone'))
            ->setAddress($this->input('address'));


        return $dto;
    }
}
