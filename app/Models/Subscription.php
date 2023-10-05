<?php

namespace App\Models;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use UsesUUID, HasFactory, SoftDeletes, GetsTableName;

    protected $guarded = [
        SubscriptionConstant::ID,
    ];

    protected $casts = [
        SubscriptionConstant::ID => 'string',
        SubscriptionConstant::STATUS => SubscriptionStatusEnum::class,
    ];

    protected static function booted()
    {
        static::created(function (self $model) {
            SubscriptionActivatedEvent::dispatch($model);
        });
    }

    /**
     * Get the plan of this subscription.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, SubscriptionConstant::PLAN_ID);
    }

    /**
     * Get the company that owns this subscription.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, SubscriptionConstant::COMPANY_ID);
    }

    /**
     * Get the addons for this subscription.
     */
    public function addOns(): HasMany
    {
        return $this->hasMany(SubscriptionAddOn::class);
    }

    public function activate(): bool
    {
        return $this->update([
            SubscriptionConstant::STATUS => SubscriptionStatusEnum::ACTIVE,
        ]);
    }
}
