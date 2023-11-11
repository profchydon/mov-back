<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateRetiredAssetDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateRetiredAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'reason' => 'required|string',
        ];
    }

    public function getDTO(): CreateRetiredAssetDTO
    {
        $dto = new CreateRetiredAssetDTO();

        $dto->setDate($this->input('date'))
            ->setReason($this->input('reason'));

        return $dto;
    }
}
