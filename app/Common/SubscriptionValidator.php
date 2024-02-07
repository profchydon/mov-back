<?php

namespace App\Common;

use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;

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
        return $this->company->activeSubscription;
    }

    /**
     * Retrieves the active subscription plan.
     *
     * @return Plan|null The active subscription plan or null if there is no active subscription.
     */
    public function getActiveSubscriptionPlan(): ?Plan
    {
        return $this->company->activeSubscription?->plan;
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
        $seatCount = count($this->company->seats);

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
        $assetCount = count($this->company->assets);

        return $assetCount < $assetLimit ? true : false;
    }
}
