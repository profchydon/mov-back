<?php

namespace App\Models;

use App\Domains\Constant\InsuranceConstant;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends BaseModel
{
    use UsesUUID;

    protected static array $searchable = [
        'provider'
    ];

    protected $casts = [
        InsuranceConstant::EXPIRATION_DATE => 'date',
        InsuranceConstant::PURCHASE_DATE => 'date',
    ];
}
