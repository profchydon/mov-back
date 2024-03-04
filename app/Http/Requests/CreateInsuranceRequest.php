<?php

namespace App\Http\Requests;

use App\Domains\Constant\InsuranceConstant;
use App\Domains\DTO\InsuranceDTO;
use App\Domains\Enum\InsuranceCoverageCycleEnum;
use App\Rules\HumanNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateInsuranceRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'provider' => ['required', new HumanNameRule()],
            'policy_id' => ['required', Rule::unique('insurances', InsuranceConstant::POLICY_ID)->where('company_id', $this->company->id)],
            'purchase_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'expiration_date' => ['required', 'date_format:Y-m-d', 'after:purchase_date'],
            'asset_premium' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'coverage_percentage' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'coverage_cycle' => ['sometimes', 'nullable', Rule::in(InsuranceCoverageCycleEnum::values())],
            'country' => ['sometimes', 'nullable', Rule::exists('countries', 'name')]
        ];
    }

    public function toDTO()
    {
        $dto = new InsuranceDTO();
        $dto->setPolicyId($this->input('policy_id'))
            ->setPurchaseDate($this->input('purchase_date'))
            ->setExpirationDate($this->input('expiration_date'))
            ->setCoveragePercentage($this->input('asset_premium'))
            ->setCoverageCycle($this->input('coverage_percentage'))
            ->setAssetPremium($this->input('coverage_cycle'));

        return $dto;
    }
}
