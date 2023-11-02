<?php

namespace App\Models;

use App\Domains\Constant\Plan\PlanPriceConstant;
use App\Domains\Constant\Plan\PlanProcessorConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        return (string)Uuid::uuid4();
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
        return $this->hasOne(PlanProcessor::class, PlanProcessorConstant::PLAN_PRICE_ID);
    }
}
