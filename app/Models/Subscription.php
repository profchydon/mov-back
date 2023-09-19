<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Subscription\SubscriptionActivatedEvent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        SubscriptionConstant::ID,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        SubscriptionConstant::ID => 'string',
        SubscriptionConstant::STATUS => SubscriptionStatusEnum::class,
    ];

    /**
     * Get the plan of this subscription
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, SubscriptionConstant::PLAN_ID);
    }

     /**
     * Get the company that owns this subscription
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, SubscriptionConstant::COMPANY_ID);
    }

    /**
     * Get the addons for this subscription
     */
    public function addOns(): HasMany
    {
        return $this->hasMany(SubscriptionAddOn::class);
    }

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return ['id'];
    }

    protected static function booted()
    {
        static::created(function(self $model){
            SubscriptionActivatedEvent::dispatch($model);
        });
    }
}
