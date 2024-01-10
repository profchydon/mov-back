<?php

namespace App\Models;

use App\Domains\Constant\VendorConstant;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;

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
