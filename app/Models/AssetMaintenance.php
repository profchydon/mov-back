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
    ];

    protected $casts = [
        AssetMaintenanceConstant::STATUS => AssetMaintenanceStatusEnum::class,
    ];

    protected static function booted()
    {
        static::created(function (self $maintenance) {
            $maintenance->asset->logForMaintainance();
        });
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, AssetMaintenanceConstant::ASSET_ID);
    }
}
