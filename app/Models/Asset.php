<?php

namespace App\Models;

use App\Domains\Constant\AssetConstant;
use App\Events\AssetStatusUpdatedEvent;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Asset extends Model
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        AssetConstant::ID => 'string',
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


        self::created(function ($asset) {
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

    public function highestBid(): HasOne
    {
        return $this->hasOne(Bid::class, 'asset_id')->orderBy('price', 'DESC');
    }

    public function available()
    {
        return $this->auction_status == AssetAuctionStatusEnum::NOT_SOLD->value;
    }
}
