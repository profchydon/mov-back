<?php

namespace App\Http\Requests;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\DTO\AddonDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddOnToSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        $subscription = $this->route('subscription');

        return [
            'currency' => ['required', Rule::exists('plan_prices', PlanPriceConstant::CURRENCY_CODE)->where(PlanPriceConstant::PLAN_ID, $subscription?->plan?->id)->where(PlanPriceConstant::BILLING_CYCLE, $subscription->billing_cycle)],
            'add-on-ids' => ['sometimes', 'nullable', 'array'],
            'add-on-ids.*' => ['sometimes', Rule::exists('features', 'id')],
            'redirect_uri' => ['required', 'string'],
        ];
    }

    public function dto()
    {
        $dto = new AddonDTO();
        $dto->setCurrency($this->input('currency'))
            ->setAddOns($this->input('add-on-ids'))
            ->setRedirectUri($this->input('redirect_uri'));

        return $dto;
    }
}
