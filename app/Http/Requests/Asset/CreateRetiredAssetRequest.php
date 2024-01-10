<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateRetiredAssetDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRetiredAssetRequest extends FormRequest
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
            'date' => 'required|date',
            'reason' => 'required|string',
            'asset_id' => ['required', Rule::exists('assets', 'id')],
        ];
    }

    public function getDTO(): CreateRetiredAssetDTO
    {
        $dto = new CreateRetiredAssetDTO();

        $dto->setDate($this->input('date'))
            ->setReason($this->input('reason'))
            ->setAssetId($this->input('asset_id'));

        return $dto;
    }
}
