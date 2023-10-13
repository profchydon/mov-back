<?php

namespace App\Models;

use App\Domains\Constant\AssetCheckoutConstant;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        AssetCheckoutConstant::STATUS => AssetCheckoutStatusEnum::class
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}
