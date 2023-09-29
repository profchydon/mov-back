<?php

namespace App\Repositories;

use App\Domains\DTO\CreateSubscriptionDTO;
use App\Models\Plan;
use App\Models\Subscription;
use App\Repositories\Contracts\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans()
    {
        return Plan::with('prices.currency')->paginate();
    }
}
