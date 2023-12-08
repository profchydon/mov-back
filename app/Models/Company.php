<?php

namespace App\Models;

use App\Domains\Constant\CompanyConstant;
use App\Domains\Constant\DepartmentConstant;
use App\Domains\Constant\SubscriptionConstant;
use App\Domains\Enum\Company\CompanyStatusEnum;
use App\Domains\Enum\Subscription\SubscriptionStatusEnum;
use App\Events\Company\CompanyCreatedEvent;
use App\Traits\QueryFormatter;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
{
    use UsesUUID, SoftDeletes, QueryFormatter;

    protected $with = ['country.currency'];

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

    public function activeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->where(SubscriptionConstant::STATUS, SubscriptionStatusEnum::ACTIVE);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserCompany::class, 'company_id', 'id', 'id', 'user_id')->whereNull('user_companies.deleted_at');
    }

    public function usersWithSeats()
    {
        return $this->users()->having('has_seats', true);
    }

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class, 'company_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class, 'company_id')->orderby(DepartmentConstant::NAME, 'ASC');
    }

    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class, 'company_id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class, 'company_id');
    }

    public function asset_maintenance()
    {
        return $this->hasMany(AssetMaintenance::class, 'company_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'company_id');
    }

    public function stolenAssets()
    {
        return $this->hasMany(StolenAsset::class, 'company_id');
    }

    public function damagedAssets()
    {
        return $this->hasMany(DamagedAsset::class, 'company_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country', 'name');
    }

    public function seats(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserCompany::class, 'company_id', 'id', 'id', 'user_id')->where('user_companies.has_seat', true);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'company_id')->whereNull('deleted_at');
    }
}
