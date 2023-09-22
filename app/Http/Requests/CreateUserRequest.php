<?php

namespace App\Http\Requests;

use App\Domains\DTO\CreateUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone_code' => 'required|string',
            'phone' => 'required|string',
            'password' => Password::min(8)->letters()->mixedCase()->numbers()->symbols(),
        ];
    }

    public function getUserDTO(): CreateUserDTO
    {
        $dto = new CreateUserDTO();
        $dto->setFirstName($this->first_name)
            ->setLastName($this->last_name)
            ->setEmail($this->email)
            ->setPhoneCode($this->phone_code)
            ->setPhone($this->phone)
            ->setPassword($this->password);

        return $dto;
    }
}
