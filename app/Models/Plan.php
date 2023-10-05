<?php

namespace App\Models;

use App\Domains\Constant\FeatureConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Plan extends BaseModel
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        FeatureConstant::ID => 'string',
        FeatureConstant::STATUS => PlanStatusEnum::class,
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
}
