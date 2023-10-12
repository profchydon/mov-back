<?php

namespace App\Models;

use App\Domains\Constant\AssetCheckoutConstant;
use App\Domains\Constant\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\GetsTableName;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use UsesUUID, HasFactory, SoftDeletes, GetsTableName;

    protected $guarded = [
        AssetConstant::ID,
    ];

    protected $hidden = [
        AssetConstant::TENANT_ID,
    ];

    protected $casts = [
        AssetConstant::ID => 'string',
    ];

    public static function boot()
    {
        parent::boot();


        self::created(function ($asset) {
        });

        self::updated(function (self $asset) {
            if ($asset->isDirty(AssetConstant::STATUS)) {
                AssetStatusUpdatedEvent::dispatch($asset);
            }
        });
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::AVAILABLE);
    }

    public function scopeAchieved(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::ARCHIVED);
    }

    public function scopeCheckedOut(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::CHECKED_OUT);
    }

    public function office()
    {
        return $this->belongsTo(Office::class, AssetConstant::OFFICE_ID);
    }

    public function type()
    {
        return $this->belongsTo(AssetType::class, AssetConstant::TYPE_ID);
    }

    public function image()
    {
        return $this->morphOne(File::class, 'fileable');

    }
  
    public function checkouts()
    {
        return $this->hasMany(AssetCheckout::class, AssetCheckoutConstant::ASSET_ID);

    }
}
