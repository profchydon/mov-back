<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetConstant;
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
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasUuids, HasApiTokens, HasFactory, Notifiable, GetsTableName, HasRoles, CausesActivity;

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

    public function userCompanies()
    {
        return $this->hasMany(UserCompany::class, UserConstant::USER_ID);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
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
        return self::class;
    }

    public function hasPermissions(string $permission)
    {
        return $this->roles->permissions()->where('permissions.name', $permission)->exists();
    }

    public function departments()
    {
        return $this->hasManyThrough(Department::class, UserDepartment::class, 'user_id', 'id', 'id', 'department_id');
    }

    public function user_departments()
    {
        return $this->hasMany(UserDepartment::class, 'user_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, AssetConstant::ASSIGNED_TO);
    }

    public function assetCount()
    {
        return $this->hasMany(Asset::class, AssetConstant::ASSIGNED_TO)->count();
    }

    public function teams()
    {
        return $this->hasManyThrough(Team::class, UserTeam::class, 'user_id', 'id', 'id', 'team_id');
    }

    public function user_teams()
    {
        return $this->hasMany(UserTeam::class, 'user_id');
    }
}
