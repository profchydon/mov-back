<?php

namespace App\Models;

use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Constant\CompanyConstant;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domains\Enum\Company\CompanyStatusEnum;
use App\Events\Company\CompanyCreatedEvent;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
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
        CompanyConstant::ID,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        CompanyConstant::TENANT_ID
    ];

    /**
     * Get the auction that owns the asset.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, CompanyConstant::TENANT_ID);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        CompanyConstant::ID => 'string',
        CompanyConstant::COMPANY_ID => 'string',
        CompanyConstant::STATUS => CompanyStatusEnum::class,
    ];

     /**
     * Get the subscriptions for this company
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    protected static function booted()
    {
        static::created(function(self $model){
            CompanyCreatedEvent::dispatch($model);
        });
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserCompany::class, 'company_id', 'id', 'id', 'user_id');
    }
}
