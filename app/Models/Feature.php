<?php

namespace App\Models;

use App\Domains\Constant\FeatureConstant;
use App\Domains\Enum\Feature\FeatureStatusEnum;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use UsesUUID, HasFactory, SoftDeletes, GetsTableName;


    protected $guarded = [
        FeatureConstant::ID,
    ];

    protected $casts = [
        FeatureConstant::ID => 'string',
        FeatureConstant::STATUS => FeatureStatusEnum::class,
    ];

    public function prices()
    {
        return $this->hasMany(FeaturePrice::class, 'feature_id');
    }
}
