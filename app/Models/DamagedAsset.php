<?php

namespace App\Models;

use App\Domains\Constant\DamagedAssetConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedAsset extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        DamagedAssetConstant::ID,
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    public function documents()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
