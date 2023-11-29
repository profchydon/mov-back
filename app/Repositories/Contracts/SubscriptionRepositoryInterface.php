<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateSubscriptionDTO;
use App\Models\Company;

interface SubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createSubscription(CreateSubscriptionDTO $subscriptionDTO);

    public function getCompanySubscription(string|Company $company);
}
