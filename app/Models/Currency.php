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

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        CurrencyConstant::ID,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        CurrencyConstant::STATUS => CurrencyStatusEnum::class,
    ];

    public static function boot()
    {
        parent::boot();
    }
}
