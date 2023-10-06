<?php

namespace App\Repositories;

use App\Domains\DTO\CreateSubscriptionDTO;
use App\Models\Subscription;
use App\Repositories\Contracts\SubscriptionRepositoryInterface;
use Illuminate\Support\Arr;

class SubscriptionRepository extends BaseRepository implements SubscriptionRepositoryInterface
{
    public function model(): string
    {
        return Subscription::class;
    }

    public function createSubscription(CreateSubscriptionDTO $subDTO)
    {
        $subscription = $this->create(Arr::except($subDTO->toArray(), 'add-on-ids'));

        if ($subDTO->getAddOnIds()->isNotEmpty()) {
            $addons = $subDTO->getAddOnIds()->map(function ($id) use ($subscription) {
                return [
                    'feature_id' => $id,
                    ...Arr::except($subscription->toArray(), ['id', 'plan_id', 'invoice_id']),
                ];
            });

            $addons->each(function ($addOn) use ($subscription) {
                $subscription->addOns()->create($addOn);
            });
        }

        return $subscription->load('addOns', 'plan');
    }
}
