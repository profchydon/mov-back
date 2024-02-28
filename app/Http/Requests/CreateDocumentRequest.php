<?php

namespace App\Http\Requests;

use App\Domains\Constant\DocumentConstant;
use App\Domains\DTO\CreateDocumentDTO;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CreateDocumentRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('documents', 'name')->where(DocumentConstant::COMPANY_ID, $this->company?->id)->whereNull('deleted_at')],
            'type' => ['required', new HumanNameRule(), Rule::exists('document_types')->where('company_id', $this->company?->id)],
            'registration_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'expiration_date' => [Rule::when(
                fn($input) => !empty($this->input('registration_date')),
                ['sometimes', 'nullable', 'date_format:Y-m-d', 'after_or_equal:registration_date']
            )],
            'file' => ['required', 'file']
        ];
    }

    public function getDTO()
    {
        $dto = new CreateDocumentDTO();
        $dto->setCompanyId($this->company?->id)
            ->setName($this->input('name'))
            ->setType($this->input('type'))
            ->setRegistrationDate($this->input('registration_date'))
            ->setExpirationDate($this->input('expiration_date'));


        return $dto;
    }
}
