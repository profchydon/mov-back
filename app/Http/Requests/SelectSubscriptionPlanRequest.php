<?php

namespace App\Http\Requests;

use App\Domains\DTO\CreateSubscriptionDTO;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

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
            'billing_cycle' => sprintf('required|string|in:%s', implode(',', BillingCycleEnum::values())),
        ];
    }

    public function getDTO()
    {
        $startDate = Carbon::now();

        if ($this->input('billing_cycle') == BillingCycleEnum::MONTHLY) {
            $endDate = $startDate->addMonth();
        } else {
            $endDate = $startDate->addYear();
        }

        $dto = new CreateSubscriptionDTO();

        $dto->setPlanId($this->input('plan_id'))
            ->setBillingCycle($this->input('billing_cycle'))
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setStatus(SubscriptionStatusEnum::ACTIVE->value);

        return $dto;
    }
}
