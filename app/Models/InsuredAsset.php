<?php

namespace App\Models;

use App\Domains\Constant\InsuranceConstant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuredAsset extends BaseModel
{
    public function asset()
    {
        return $this->belongsTo(Asset::class, InsuranceConstant::ASSET_ID);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class, InsuranceConstant::INSURANCE_ID);
    }
}
