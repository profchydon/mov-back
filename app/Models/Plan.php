<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use App\Domains\Enum\Plan\PlanStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

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

    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds()
    {
        return ['id'];
    }

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
}
