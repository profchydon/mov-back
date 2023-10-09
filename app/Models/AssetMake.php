<?php

namespace App\Models;

use App\Domains\Constant\AssetMakeConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMake extends Model
{
    use HasFactory;

    protected $guarded = [
        AssetMakeConstant::ID,
    ];

    protected $hidden = [
        AssetMakeConstant::TENANT_ID,
    ];
}
