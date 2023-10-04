<?php

namespace App\Http\Requests;

use App\Domains\DTO\VerifyOTPDTO;
use Illuminate\Foundation\Http\FormRequest;

class VerifyOTPRequest extends FormRequest
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
            'otp' => 'required|string|size:4',
            'userId' => 'required|string',
        ];
    }

    public function getDTO(): VerifyOTPDTO
    {
        $dto = new VerifyOTPDTO();

        $dto->setOTP($this->input('otp'))
            ->setUserId($this->input('userId'));

        return $dto;
    }
}
