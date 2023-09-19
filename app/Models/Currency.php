<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\CurrencyConstant;
use App\Domains\Enum\Currency\CurrencyStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory, SoftDeletes, GetsTableName;

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
