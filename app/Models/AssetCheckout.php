<?php

namespace App\Models;

use App\Domains\Constant\AssetCheckoutConstant;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetCheckout extends BaseModel
{
    use UsesUUID;

    protected $casts = [
        AssetCheckoutConstant::STATUS => 'json'
    ];

    protected $hidden = [
        AssetCheckoutConstant::TENANT_ID,
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
