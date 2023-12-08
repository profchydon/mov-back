<?php

namespace App\Models;

use App\Domains\Constant\VendorConstant;
use App\Traits\GetsTableName;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends BaseModel
{
    use UsesUUID, HasCompany;

    protected $guarded = [
        VendorConstant::ID,
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class, 'vendor_id');
    }
}
