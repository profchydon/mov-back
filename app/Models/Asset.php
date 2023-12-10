<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\Asset\AssetMaintenanceConstant;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends BaseModel
{
    use UsesUUID, HasFactory, SoftDeletes, LogsActivity;

    protected static $searchable = [
        'make',
        'model',
    ];

    protected static $filterable = [
        'condition' => 'assets.condition',
        'type' => 'assets.type_id',
        'assignee' => 'assets.assigned_to',
        'created' => 'assets.created_at',
        'currency' => 'assets.currency',
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

    public function scopeArchieved(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::ARCHIVED);
    }

    public function scopeCheckedOut(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::CHECKED_OUT);
    }

    public function scopeDamaged(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::DAMAGED);
    }

    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->where(AssetConstant::ADDED_AT, now()->day());
    }

    public function scopeStatus($query, array $status)
    {
        return $query->whereIn(AssetConstant::STATUS, $status);
    }

    public function office()
    {
        return $this->belongsTo(Office::class, AssetConstant::OFFICE_ID);
    }

    public function officeArea()
    {
        return $this->belongsTo(OfficeArea::class, AssetConstant::OFFICE_AREA_ID);
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

    public function maintenances()
    {
        return $this->hasMany(AssetMaintenance::class, AssetMaintenanceConstant::ASSET_ID);
    }

    public function logForMaintainance()
    {
        return $this->update([
            'status' => AssetStatusEnum::UNDER_MAINTENANCE,
        ]);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
