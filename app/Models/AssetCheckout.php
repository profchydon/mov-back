<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetCheckout extends BaseModel
{
    use UsesUUID;

    protected static function booted()
    {
        parent::booted();
        static::created(function (self $checkout) {
            $checkout->asset->checkout();
        });
    }

    protected $casts = [
        AssetCheckoutConstant::STATUS => AssetCheckoutStatusEnum::class,
    ];

    protected $hidden = [
        AssetCheckoutConstant::TENANT_ID,
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function checkedOutBy()
    {
        return $this->belongsTo(User::class, 'checkout_by');
    }

    public function scopeStatus($query, array $status)
    {
        return $query->whereIn(AssetCheckoutConstant::STATUS, $status);
    }

    public function scopeNotstatus($query, array $status)
    {
        return $query->whereNotIn(AssetCheckoutConstant::STATUS, $status);
    }
}
