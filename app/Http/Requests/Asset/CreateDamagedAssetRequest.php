<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateDamagedAssetDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateDamagedAssetRequest extends FormRequest
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
            'comment' => 'required|string',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file'
        ];
    }

    public function getDTO(): CreateDamagedAssetDTO
    {
        $dto = new CreateDamagedAssetDTO();

        $dto->setDate($this->input('date'))
            ->setComment($this->input('comment'));

        return $dto;
    }
}
