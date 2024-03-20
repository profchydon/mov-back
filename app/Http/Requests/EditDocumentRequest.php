<?php

namespace App\Http\Requests;

use App\Domains\Constant\DocumentConstant;
use App\Domains\DTO\CreateDocumentDTO;
use App\Domains\DTO\UpdateDocumentDTO;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class EditDocumentRequest extends FormRequest
{

    public function authorize()
    {
        $user_id =  Auth::id() ?? "9b183bb7-d0bf-4ab5-b869-78e8fdc6480c";

        return $this->document->user_id == $user_id;
    }


    public function rules(): array
    {
        $reg_date = $this->input('registration_date') ?? $this->document->registration_date;

        return [
            'name' => ['sometimes', Rule::unique('documents', 'name')->where(DocumentConstant::COMPANY_ID, $this->company?->id)->whereNull('deleted_at')->ignore($this->document)],
            'type' => 'nullable|string',
            'owner_id' => ['sometimes', 'nullable', Rule::exists('user_companies', 'user_id')->where('company_id', $this->company?->id)],
            'registration_date' => ['sometimes', 'nullable', 'date_format:Y-m-d'],
            'expiration_date' => ['sometimes', 'nullable', 'date_format:Y-m-d', "after_or_equal:{$reg_date}"],
        ];
    }

    public function getDTO()
    {
        $dto = new UpdateDocumentDTO();
        $dto->setName($this->input('name'))
            ->setType($this->input('type'))
            ->setRegistrationDate($this->input('registration_date'))
            ->setOwnerId($this->input('owner_id'))
            ->setExpirationDate($this->input('expiration_date'));

        return $dto;
    }
}
