<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\Contracts\PlanRepositoryInterface;

class PlanRepository implements PlanRepositoryInterface
{
    public function getPlans()
    {
        return Plan::with('prices.currency')->orderBy('rank', 'asc')->paginate();
    }
}
