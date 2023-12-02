<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateStolenAssetDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateStolenAsset extends FormRequest
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
        $company = $this->route('company');

        return [
            'asset_id' => ['required', Rule::exists('assets', 'id')->where('company_id', $company->id)],
            'date' => 'required|date_format:Y-m-d',
            'comment' => 'required|string',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file',
        ];
    }

    public function getDTO(): CreateStolenAssetDTO
    {
        $dto = new CreateStolenAssetDTO();

        $dto->setDate($this->input('date'))
            ->setComment($this->input('comment'));

        return $dto;
    }
}
