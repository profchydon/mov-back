<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\PlanConstant;
use App\Domains\Enum\Plan\PlanStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends BaseModel
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        PlanConstant::ID => 'string',
        PlanConstant::OFFERS => 'json',
        PlanConstant::STATUS => PlanStatusEnum::class,
    ];

    public function newUniqueId()
    {
        return (string)Uuid::uuid4();
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
