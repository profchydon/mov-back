<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetCheckoutConstant;
use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\Asset\AssetMaintenanceConstant;
use App\Domains\Enum\Asset\AssetConditionEnum;
use App\Domains\Enum\Asset\AssetStatusEnum;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Number;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends BaseModel
{
    use UsesUUID, HasFactory, SoftDeletes, LogsActivity;

    protected static $searchable = [
        'make',
        'model',
        'serial_number',
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

    public function getEventDescription($eventName)
    {
        if (Str::lower($eventName) == 'updated' && $this->isDirty('status')) {
            return "Asset was marked as " . Str::lower($this->status->value ?? $this->status);
        }

        return parent::getEventDescription($eventName);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($asset) {
            // Code for the created event
        });

        self::updated(function (self $asset) {
            if ($asset->isDirty(AssetConstant::STATUS)) {
                AssetStatusUpdatedEvent::dispatch($asset);
            }

            // if (!$asset->hasMissingInformtion()) {
            //     $asset->update([
            //         AssetConstant::CONDITION => AssetConditionEnum::WORKING_PERFECTLY,
            //     ]);
            // }
        });
    }

    public function hasMissingInformtion()
    {
        return
            $this->getAttribute(AssetConstant::MAKE) === null ||
            $this->getAttribute(AssetConstant::MODEL) === null ||
            $this->getAttribute(AssetConstant::SERIAL_NUMBER) === null ||
            $this->getAttribute(AssetConstant::TYPE_ID) === null ||
            $this->getAttribute(AssetConstant::PURCHASE_PRICE) === null ||
            $this->getAttribute(AssetConstant::PURCHASE_DATE) === null ||
            $this->getAttribute(AssetConstant::CURRENCY) === null ||
            $this->getAttribute(AssetConstant::MAINTENANCE_CYCLE) === null ||
            $this->getAttribute(AssetConstant::NEXT_MAINTENANCE_DATE) === null;
    }

    public function scopeExcludeArchived(Builder $query): Builder
    {
        return $query->whereNot(AssetConstant::STATUS, AssetStatusEnum::ARCHIVED);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where(AssetConstant::STATUS, AssetStatusEnum::AVAILABLE);
    }

    public function scopeArchived(Builder $query): Builder
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

    public function scopeInsured(Builder $query)
    {
        return $query->where('is_insured', true);
    }

    public function scopeUnInsured(Builder $query)
    {
        return $query->where('is_insured', false);
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function checkout()
    {
        $this->status = AssetStatusEnum::CHECKED_OUT;
        $this->save();

        return $this->fresh();
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

    public function checkedOut(): bool
    {
        return $this->status === AssetStatusEnum::CHECKED_OUT->value;
    }

    // public function documents()
    // {
    //     return $this->hasMany(Document::class, 'document_id');
    // }

    public function documents()
    {
        return $this->belongsToMany(Document::class, 'asset_documents', 'asset_id', 'document_id');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /* see here for tips on calculation
   https://app.clickup.com/4640992/v/dc/4dm70-4308/4dm70-708
    */
    public function calculateScore()
    {
        $score = 0;
        if ($this->documents()->exists()) {
            $score += 10;
        }

        if ($this->assignee()->exists()) {
            $score += 10;
        }

        if ($this->maintenances()->exists()) {
            $score += 30;
        }

        if ($this->status != AssetStatusEnum::PENDING_APPROVAL->value && $this->updated_at > $this->created_at) {
            $score += 15;
        }

        if ($this->is_insured) {
            $score += 20;
        }

        return $score;
    }

    public static function getScoreGrade($score)
    {
        if ($score <= 30){
            return 'F';
        }elseif ($score <=50){
            return 'C';
        }elseif ($score <= 70){
            return 'B';
        }

        return 'A';
    }
}
