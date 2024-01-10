<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetTypeConstant;
use App\Domains\Enum\Asset\AssetTypeStatusEnum;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetType extends BaseModel
{
    use UsesUUID;


    protected $guarded = [
        AssetTypeConstant::ID,
    ];

    protected $casts = [
        AssetTypeConstant::ID => 'string',
        AssetTypeConstant::STATUS => AssetTypeStatusEnum::class,
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
