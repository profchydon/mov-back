<?php

namespace App\Models;

use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends BaseModel
{
    use UsesUUID, SoftDeletes, HasCompany;

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
//            SubscriptionActivatedEvent::dispatch($model);
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
     * Get the addons for this subscription.
     */
    public function addOns(): HasMany
    {
        return $this->hasMany(SubscriptionAddOn::class);
    }

    /**
     * Get the invoice for this subscription.
     */
    public function invoice(): MorphOne
    {
        return $this->morphOne(Invoice::class, 'billable');
    }

    public function payment()
    {
        return $this->hasOne(SubscriptionPayment::class, 'subscription_id');
    }

    public function activate(): bool
    {
        return $this->update([
            SubscriptionConstant::STATUS => SubscriptionStatusEnum::ACTIVE,
        ]);
    }
}
