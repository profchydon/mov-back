<?php

namespace App\Models;

use App\Domains\Constant\CompanyConstant;
use App\Domains\Enum\Company\CompanyStatusEnum;
use App\Events\Company\CompanyCreatedEvent;
use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use UsesUUID, HasFactory, SoftDeletes, GetsTableName, QueryFormatter;

    protected $guarded = [
        CompanyConstant::ID,
    ];

    protected $hidden = [
        CompanyConstant::TENANT_ID,
        // CompanyConstant::SSO_ID,
    ];

    protected $casts = [
        CompanyConstant::ID => 'string',
        CompanyConstant::COMPANY_ID => 'string',
        CompanyConstant::STATUS => CompanyStatusEnum::class,
    ];

    protected static function booted()
    {
        static::created(function (self $model) {
            CompanyCreatedEvent::dispatch($model);
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, CompanyConstant::TENANT_ID);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserCompany::class, 'company_id', 'id', 'id', 'user_id');
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class, 'company_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'company_id');
    }
    
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'company_id');
    }
}
