<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Domains\Enum\Plan\PlanProcessorNameEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PlanPrice extends BaseModel
{
    use UsesUUID, SoftDeletes;

    protected $casts = [
        PlanPriceConstant::ID => 'string',
        PlanPriceConstant::BILLING_CYCLE => BillingCycleEnum::class,
    ];

    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    public function uniqueIds()
    {
        return ['id'];
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function processor()
    {
        return $this->hasMany(PlanProcessor::class, PlanProcessorConstant::PLAN_PRICE_ID);
    }

    public function flutterwaveProcessor()
    {
        return $this->processor()->where(PlanProcessorConstant::PLAN_PROCESSOR_NAME, PlanProcessorNameEnum::FLUTTERWAVE);
    }

    public function swipeProcessor()
    {
        return $this->processor()->where(PlanProcessorConstant::PLAN_PROCESSOR_NAME, PlanProcessorNameEnum::STRIPE);
    }
}
