<?php

namespace App\Repositories\Contracts;

use App\Domains\DTO\CreateSubscriptionDTO;

interface SubscriptionRepositoryInterface extends BaseRepositoryInterface
{
    public function createSubscription(CreateSubscriptionDTO $subscriptionDTO);
}
