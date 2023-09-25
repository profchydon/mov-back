<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\PlanPriceConstant;
use App\Domains\Enum\Plan\BillingCycleEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


}
