<?php

namespace App\Models;

use App\Domains\Constant\FeatureConstant;
use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\Plan\PlanFeatureConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use App\Domains\Enum\Plan\PlanStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Feature;

class Plan extends BaseModel
{
    use UsesUUID, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        PlanConstant::ID => 'string',
        PlanConstant::STATUS => PlanStatusEnum::class,
        PlanConstant::OFFERS => 'json',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(PlanPrice::class);
    }

    public function processors()
    {
        return $this->hasManyThrough(PlanProcessor::class, PlanPrice::class);
    }

    public function flutterwaveProcessors()
    {
        return $this->processors()->where(PlanProcessorConstant::PLAN_PROCESSOR_NAME, PlanProcessorNameEnum::FLUTTERWAVE);
    }

    public function swipeProcessers(){
        return $this->processors()->where(PlanProcessorConstant::PLAN_PROCESSOR_NAME, PlanProcessorNameEnum::STRIPE);
    }

    public function invoice_type()
    {
        return 'plan';
    }

    public function planFeatures()
    {
        return $this->hasMany(PlanFeature::class, 'plan_id');
    }

    public function features()
    {
        return $this->hasManyThrough(Feature::class, PlanFeature::class, 'plan_id', 'id', 'id', 'feature_id');
    }

    public function planSeat()
    {
        $feature = $this->features()->where(FeatureConstant::NAME, 'Seat')->first();
        return $this->planFeatures()->where(PlanFeatureConstant::FEATURE_ID, $feature?->id);
    }

    public function planAsset()
    {
        $feature = $this->features()->where(FeatureConstant::NAME, 'Asset')->first();
        return $this->planFeatures()->where(PlanFeatureConstant::FEATURE_ID, $feature?->id);
    }

}
