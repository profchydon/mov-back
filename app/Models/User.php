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

    use HasApiTokens {
        createToken as createBaseToken;
    }


    protected $guarded = [
        UserConstant::ID,
    ];


    protected $hidden = [
        UserConstant::TENANT_ID,
        UserConstant::SSO_ID,
    ];


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

    public function roles()
    {
        return $this->hasManyThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id');
    }

    public function otp()
    {
        return $this->hasOne(OTP::class);
    }

    public function logoutFromSSO()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getMorphClass()
    {
        return User::class;
    }
}
