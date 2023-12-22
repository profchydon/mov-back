<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetMaintenanceConstant;
use App\Domains\Enum\Asset\AssetMaintenanceStatusEnum;

class AssetMaintenance extends BaseModel
{
    protected static $searchable = [
        'reason',
        'comment',
    ];

    protected static $filterable = [
        'receiver' => 'assets_maintenances.receiver_id',
        'status' => 'asset_maintenances.status',
        'asset' => 'assets.id',
        'created' => 'assets.created_at',
    ];

    protected $casts = [
        AssetMaintenanceConstant::STATUS => AssetMaintenanceStatusEnum::class,
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function (self $maintenance) {
            $maintenance->asset->logForMaintainance();
        });
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, AssetMaintenanceConstant::ASSET_ID);
    }

    public function receiver()
    {
        return $this->morphTo();
    }
}
