<?php

namespace App\Models;

use App\Domains\Constant\InsuranceConstant;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Insurance extends BaseModel
{
    use UsesUUID, LogsActivity;

    protected static array $searchable = [
        'provider'
    ];

    protected $casts = [
        InsuranceConstant::EXPIRATION_DATE => 'date',
        InsuranceConstant::PURCHASE_DATE => 'date',
    ];

    public function assets()
    {
        return $this->hasManyThrough(Asset::class, InsuredAsset::class);
    }
}
