<?php

namespace App\Http\Requests\Asset;

use App\Domains\DTO\Asset\CreateDamagedAssetDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDamagedAssetRequest extends FormRequest
{

    public function rules(): array
    {
        $company = $this->route('company');

        return [
            'asset_id' => ['required', Rule::exists('assets', 'id')->where('company_id', $company->id)],
            'date' => 'required|date',
            'comment' => 'required|string',
            'documents' => 'nullable|array',
            'documents.*' => 'nullable|file',
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
