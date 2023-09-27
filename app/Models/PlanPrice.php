<?php

namespace App\Models;

use App\Domains\Constant\PlanPriceConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class PlanPrice extends BaseModel
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

    public $incrementing = false;

    protected $keyType = 'string';

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
}
