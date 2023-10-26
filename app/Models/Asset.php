<?php

namespace App\Models;

use App\Domains\Constant\AssetCheckoutConstant;
use App\Domains\Constant\AssetConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends BaseModel
{
    use UsesUUID, HasFactory, SoftDeletes;

    protected static $searchable = [
        'make',
        'model',
    ];

    protected static $filterable = [
        'condition' => 'assets.condition',
        'type' => 'assets.type_id',
        'assignee' => 'assets.assigned_to',
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

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function checkout()
    {
        return $this->update([
            'status' => AssetStatusEnum::CHECKED_OUT,
        ]);
    }
}
