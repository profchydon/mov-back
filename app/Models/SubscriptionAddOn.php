<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\SubscriptionAddOnConstant;
use App\Domains\Enum\Subscription\SubscriptionAddOnStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionAddOn extends Model
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
        SubscriptionAddOnConstant::ID,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        SubscriptionAddOnConstant::ID => 'string',
        SubscriptionAddOnConstant::STATUS => SubscriptionAddOnStatusEnum::class,
    ];

    /**
     * Get the subscription tied to this add on
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, SubscriptionAddOnConstant::SUBSCRIPTION_ID);
    }

    /**
     * Get the feature tied to this add on
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class, SubscriptionAddOnConstant::FEATURE_ID);
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

    public static function boot()
    {
        parent::boot();

    }
}
