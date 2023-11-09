<?php

namespace App\Models;

use App\Domains\Constant\StolenAssetConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StolenAsset extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        StolenAssetConstant::ID,
    ];

    public function documents()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
