<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\AddonDTO;
use App\Domains\DTO\CreateSubscriptionDTO;
use App\Models\Company;
use App\Models\Plan;
use App\Models\Subscription;

interface SubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createSubscription(CreateSubscriptionDTO $subscriptionDTO);

    public function addAddOnsToSubsciption(string|Subscription $subscription, AddonDTO $addonDTO);

    public function getCompanySubscription(string|Company $company);

    public function changeSubscription(Subscription $oldSub, Plan $newPlan, CreateSubscriptionDTO $subDTO);

    public function downgradeSubscription(Subscription $oldSub, Plan $newPlan);

    public function upgradeSubscription(Subscription $oldSub, Plan $newPlan);
}
