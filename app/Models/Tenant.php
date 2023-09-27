<?php

namespace App\Models;

use App\Domains\Constant\TenantConstant;
use App\Domains\Enum\Tenant\TenantStatusEnum;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasUuids, HasFactory, SoftDeletes, GetsTableName;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        TenantConstant::ID,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        TenantConstant::ID => 'string',
        TenantConstant::STATUS => TenantStatusEnum::class,
    ];

    public static function boot()
    {
        parent::boot();
    }
}
