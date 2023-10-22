<?php

namespace App\Models;

use App\Domains\Constant\AssetTypeConstant;
use App\Domains\Enum\Asset\AssetTypeStatusEnum;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use App\Traits\WithActivityLog;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

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
