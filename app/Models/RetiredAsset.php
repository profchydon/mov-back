<?php

namespace App\Models;

use App\Domains\Constant\RetiredAssetConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetiredAsset extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        RetiredAssetConstant::ID,
    ];
}
