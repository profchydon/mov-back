<?php

namespace App\Common;

use App\Domains\Constant\InvoiceConstant;
use App\Domains\Constant\InvoiceItemConstant;
use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionValidator
{
    /**
     * SubscriptionValidator constructor.
     * @param Company $company
     */
    public function __construct(private readonly Company $company)
    {
    }

    /**
     * Retrieves the active subscription for the current company.
     *
     * @return Subscription|null The active subscription object or null if there is no active subscription.
     */
    public function getActiveSubscription(): ?Subscription
    {
        $subscription = $this->company->activeSubscription;

        if (!$subscription) {
            $subscription = $this->createBasicSubscription();
        }

        return $subscription;
    }

    /**
     * Retrieves the active subscription plan.
     *
     * @return Plan|null The active subscription plan or null if there is no active subscription.
     */
    public function getActiveSubscriptionPlan(): ?Plan
    {
        $activeSubscription = $this->getActiveSubscription();

        return $activeSubscription?->plan;
    }

    /**
     * Retrieves the seat limit of the active subscription plan.
     *
     * @return int The seat limit of the active subscription plan.
     */
    public function getActiveSubscriptionPlanSeatLimit(): int
    {
        $activePlan = $this->getActiveSubscriptionPlan();
        $planSeat = $activePlan->planSeat->first();

        return $planSeat ? (int) $planSeat->value : 0;
    }

    /**
     * Retrieves the asset limit of the active subscription plan.
     *
     * @return int The asset limit of the active subscription plan.
     */
    public function getActiveSubscriptionPlanAssetLimit(): int
    {
        $activePlan = $this->getActiveSubscriptionPlan();
        $planAsset = $activePlan->planAsset->first();

        return $planAsset ? (int) $planAsset->value : 0;
    }

    /**
     * Checks if there are available seats for the company's subscription plan.
     *
     * @return bool Returns true if there are available seats, false otherwise.
     */
    public function hasAvailableSeats(): bool
    {
        $seatLimit = $this->getActiveSubscriptionPlanSeatLimit();
        $seatCount = $this->company->seats()->count();

        return $seatCount < $seatLimit ? true : false;
    }

    /**
     * Checks if there are available assets for the company's subscription plan.
     *
     * @return bool Returns true if there are available assets, false otherwise.
     */
    public function hasAvailableAssets(): bool
    {
        $assetLimit = $this->getActiveSubscriptionPlanAssetLimit();
        $assetCount = $this->company->availableAssets()->count();

        return $assetCount < $assetLimit ? true : false;
    }

    /**
     * Checks if the seat limit of the active subscription plan has been exceeded.
     *
     * @return bool Returns true if the seat limit has been exceeded, false otherwise.
     */
    public function seatLimitExceeded(): bool
    {
        $seatLimit = $this->getActiveSubscriptionPlanSeatLimit();
        $seatCount = $this->company->seats()->count();

        return $seatCount > $seatLimit ? true : false;
    }

    /**
     * Checks if the assets limit of the active subscription plan has been exceeded.
     *
     * @return bool Returns true if the assets limit has been exceeded, false otherwise.
     */
    public function assetLimitExceeded(): bool
    {
        $assetLimit = $this->getActiveSubscriptionPlanAssetLimit();
        $assetCount = $this->company->availableAssets()->count();

        return $assetCount > $assetLimit ? true : false;
    }


    /**
     * Retrieves the total number of seats for the company.
     *
     * @return int Returns the total number of seats for the company.
     */
    public function getSeatCount()
    {
        return $this->company->seats()->count();
    }


    /**
     * Retrieves the total number of assets for the company.
     *
     * @return int The total number of assets for the company.
     */
    public function getAssetCount()
    {
        return $this->company->availableAssets()->count();
    }

    /**
     * Retrieves the number of available assets left for the company.
     *
     * This method calculates the difference between the asset limit of the
     * active subscription plan and the total number of assets available for
     * the company.
     *
     * @return int The number of available assets left for the company.
     */
    public function getAssetSpaceLeft(): int
    {
        $assetLimit = $this->getActiveSubscriptionPlanAssetLimit();
        $assetCount = $this->company->availableAssets()->count();

        return (int) $assetLimit - $assetCount;
    }

    /**
     * Creates a basic subscription for the company.
     *
     * @return Subscription The created subscription.
     */
    public function createBasicSubscription(): Subscription
    {
        $basicPlan = Plan::where(PlanConstant::NAME, 'Basic')->first();

        $subscription = $this->company->subscriptions()->create([
            SubscriptionConstant::TENANT_ID => $this->company->tenant_id,
            SubscriptionConstant::COMPANY_ID => $this->company->id,
            SubscriptionConstant::PLAN_ID => $basicPlan->id,
            SubscriptionConstant::START_DATE => Carbon::now(),
            SubscriptionConstant::END_DATE => Carbon::now()->addYear(1),
            SubscriptionConstant::BILLING_CYCLE => BillingCycleEnum::YEARLY->value,
            SubscriptionConstant::STATUS => SubscriptionStatusEnum::ACTIVE->value,
        ]);

        $invoice = $subscription->invoice()->create([
            InvoiceConstant::TENANT_ID => $this->company->tenant_id,
            InvoiceConstant::COMPANY_ID => $this->company->id,
            InvoiceConstant::DUE_AT => Carbon::now()->addHours(24),
            InvoiceConstant::SUB_TOTAL => 0.00,
            InvoiceConstant::CURRENCY_CODE => 'NGN',
            InvoiceConstant::BILLABLE_ID => $subscription->id,
            InvoiceConstant::BILLABLE_TYPE => Subscription::class,
            InvoiceConstant::STATUS => InvoiceStatusEnum::PAID->value,

        ]);

        $invoice->items()->create([
            InvoiceItemConstant::INVOICE_ID => $invoice->id,
            InvoiceItemConstant::ITEM_TYPE => Plan::class,
            InvoiceItemConstant::ITEM_ID => $basicPlan->id,
            InvoiceItemConstant::QUANTITY => 1,
            InvoiceItemConstant::AMOUNT => 0.00,
        ]);

        return $subscription;
    }
}
