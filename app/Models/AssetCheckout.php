<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Constant\Asset\AssetMaintenanceConstant;
use App\Domains\Enum\Asset\AssetCheckoutStatusEnum;
use App\Domains\Enum\Asset\AssetMaintenanceStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetCheckout extends BaseModel
{
    use UsesUUID;

    protected static $searchable = [
        'asset.make',
        'asset.model',
        'asset.serial_number'
    ];

    protected static $filterable = [
        'condition' => 'assets.condition',
        'type' => 'assets.type_id',
        'assignee' => 'assets.assigned_to',
    ];


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

    public static function boot()
    {
        parent::boot();

        self::created(function (self $checkout) {
            if ($checkout->getAttribute(AssetCheckoutConstant::REASON) === 'Maintenance') {
                $checkout->asset->maintenances()->create([
                    AssetMaintenanceConstant::TENANT_ID => $checkout->getAttribute(AssetCheckoutConstant::TENANT_ID),
                    AssetMaintenanceConstant::COMPANY_ID => $checkout->getAttribute(AssetCheckoutConstant::COMPANY_ID),
                    AssetMaintenanceConstant::GROUP_ID => $checkout->getAttribute(AssetCheckoutConstant::GROUP_ID),
                    AssetMaintenanceConstant::REASON => $checkout->getAttribute(AssetCheckoutConstant::REASON),
                    AssetMaintenanceConstant::RECEIVER_ID => $checkout->getAttribute(AssetCheckoutConstant::RECEIVER_ID),
                    AssetMaintenanceConstant::RETURN_DATE => $checkout->getAttribute(AssetCheckoutConstant::RETURN_DATE),
                    AssetMaintenanceConstant::COMMENT => $checkout->getAttribute(AssetCheckoutConstant::COMMENT),
                    AssetMaintenanceConstant::STATUS => AssetMaintenanceStatusEnum::LOGGED->value,
                ]);

                $checkout->asset->logForMaintainance();
            }
        });
    }

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
