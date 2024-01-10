<?php

namespace App\Http\Requests;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Domains\Enum\Plan\BillingCycleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class SelectSubscriptionPlanRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'plan_id' => 'required|string|exists:plans,id',
            'billing_cycle' => ['required', Rule::exists('plan_prices', PlanPriceConstant::BILLING_CYCLE)->where(PlanPriceConstant::PLAN_ID, $this->input('plan_id'))],
            'currency' => ['required', Rule::exists('plan_prices', PlanPriceConstant::CURRENCY_CODE)->where(PlanPriceConstant::PLAN_ID, $this->input('plan_id'))->where(PlanPriceConstant::BILLING_CYCLE, $this->input('billing_cycle'))],
            'add-on-ids' => ['sometimes', 'nullable', 'array'],
            'add-on-ids.*' => ['sometimes', Rule::exists('features', 'id')],
            'redirect_uri' => ['required', 'string'],
        ];
    }

    public function getDTO()
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now();

        if ($this->input('billing_cycle') == BillingCycleEnum::MONTHLY->value) {
            $endDate = $endDate->addMonth();
        } elseif ($this->input('billing_cycle') == BillingCycleEnum::YEARLY->value) {
            $endDate = $endDate->addYear();
        }

        $dto = new CreateSubscriptionDTO();

        $dto->setPlanId($this->input('plan_id'))
            ->setBillingCycle($this->input('billing_cycle'))
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setRedirectURI($this->input('redirect_uri'))
            ->setCurrency($this->input('currency'))
            ->setAddOnIds($this->input('add-on-ids'));

        return $dto;
    }
}
