<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateAssetTypeDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateAssetTypeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function createAssetTypeDTO(): CreateAssetTypeDTO
    {
        $dto = new CreateAssetTypeDTO();
        $dto->setName($this->input('name'));
        return $dto;
    }

}
