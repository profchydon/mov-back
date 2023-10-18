<?php

namespace App\Models;

use App\Domains\Constant\VendorConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GetsTableName;

class Vendor extends Model
{
    use HasFactory, HasUuids, SoftDeletes, GetsTableName;

    protected $guarded = [
        VendorConstant::ID
    ];
}
