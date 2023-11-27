<?php

namespace App\Models;

use App\Domains\Constant\CurrencyConstant;
use App\Domains\Enum\Currency\CurrencyStatusEnum;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory, GetsTableName;

    protected $guarded = [
        CurrencyConstant::ID,
    ];

    protected $casts = [
        CurrencyConstant::STATUS => CurrencyStatusEnum::class,
    ];

    public static function boot()
    {
        parent::boot();
    }
}
