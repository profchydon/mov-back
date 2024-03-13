<?php

namespace App\Http\Resources\Subscription;

use App\Common\SubscriptionValidator;
use App\Http\Resources\Plan\PlanResource;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    public $collects = Subscription::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'billing_cycle' => $this->billing_cycle,
            'status' => $this->status,
        ];

        // Check if 'plan' relationship was loaded in the query
        if ($this->relationLoaded('plan')) {
            $resourceArray['plan'] = new PlanResource($this->plan);
        } else {
            $resourceArray['plan'] = null;
        }

        $subscriptionValidator = new SubscriptionValidator($this->company);

        $resourceArray['access'] = [
            'seatCount' => $subscriptionValidator->getSeatCount(),
            'assetCount' => $subscriptionValidator->getAssetCount(),
            'assetLimit' => $subscriptionValidator->getActiveSubscriptionPlanAssetLimit(),
            'seatLimit' => $subscriptionValidator->getActiveSubscriptionPlanSeatLimit(),
            'seatLimit' => $subscriptionValidator->getActiveSubscriptionPlanSeatLimit(),
            'hasAvailableSeats' => $subscriptionValidator->hasAvailableSeats(),
            'hasAvailableAssets' => $subscriptionValidator->hasAvailableAssets(),
            'hasExceededAssetLimit' => $subscriptionValidator->assetLimitExceeded(),
            'hasExceededSeatLimit' => $subscriptionValidator->seatLimitExceeded(),
        ];



        return $resourceArray;
    }
}
