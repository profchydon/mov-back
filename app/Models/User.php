<?php

namespace App\Models;

use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStatusEnum;
use App\Events\UserCreatedEvent;
use App\Events\UserDeactivatedEvent;
use App\Traits\GetsTableName;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasUuids, HasApiTokens, HasFactory, Notifiable, GetsTableName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        UserConstant::ID,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        UserConstant::TENANT_ID,
        UserConstant::SSO_ID,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function (self $model) {
            // UserCreatedEvent::dispatch($model);
        });

        static::updated(function (self $model) {
            if ($model->status == UserStatusEnum::DEACTIVATED) {
                // UserDeactivatedEvent::dispatch($model);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function userCompanies()
    {
        return $this->hasMany(UserCompany::class, UserConstant::USER_ID);
    }

    public function otp()
    {
        return $this->hasOne(OTP::class);
    }
}
