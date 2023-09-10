<?php

namespace App\Models;

use App\Domains\Constant\AssetConstant;
use App\Domains\Enum\Asset\AssetAuctionStatusEnum;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName, LogsActivity;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $with = ['image'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        AssetConstant::ID,
    ];

    /**
     * Get the asset images that belongs to the asset.
     */
    public function assetImages()
    {
        return $this->hasMany(AssetImage::class);
    }

    /**
     * Get the auction that owns the asset.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class, AssetConstant::AUCTION_ID);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        AssetConstant::ID => 'string',
        AssetConstant::COMPANY_ID => 'string',
        AssetConstant::STATUS => AssetAuctionStatusEnum::class,
    ];

    /**
     * Generate a new UUID for the model.
     *
     * @return string
     */
    public function newUniqueId()
    {
        return (string) Uuid::uuid4();
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return ['id'];
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($asset) {
            $asset->assetImages()->each(function ($asset_image) {
                $asset_image->delete();
            });
        });

        self::updated(function (self $asset) {
            if ($asset->isDirty(AssetConstant::AUCTION_STATUS)) {
                AssetStatusUpdatedEvent::dispatch($asset);
            }
        });
    }

    public function image()
    {
        return $this->morphMany(FileUpload::class, 'uploadable');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'asset_id');
    }

    public function highestBid(): HasOne
    {
        return $this->hasOne(Bid::class, 'asset_id')->orderBy('price', 'DESC');
    }

    public function available()
    {
        return $this->auction_status == AssetAuctionStatusEnum::NOT_SOLD->value;
    }
}
