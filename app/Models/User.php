<?php

namespace App\Models;

use App\Domains\Constant\Asset\AssetConstant;
use App\Domains\Constant\UserConstant;
use App\Domains\Enum\User\UserStageEnum;
use App\Domains\Enum\User\UserStatusEnum;
use App\Events\User\UserCreatedEvent;
use App\Events\UserDeactivatedEvent;
use App\Traits\GetsTableName;
use App\Traits\QueryFormatter;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasUuids, HasApiTokens, HasFactory, Notifiable, GetsTableName, HasRoles, CausesActivity, QueryFormatter;

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
        static::created(function (self $user) {
            if ($user->stage == UserStageEnum::COMPLETED->value) {
                UserCreatedEvent::dispatch($user);
            }
        });

        static::updated(function (self $user) {
            if ($user->status == UserStatusEnum::DEACTIVATED) {
                // UserDeactivatedEvent::dispatch($model);
            }
            if ($user->isDirty(UserConstant::STAGE) && $user->stage == UserStageEnum::COMPLETED->value) {
                UserCreatedEvent::dispatch($user);
            }
        });
    }

    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $token = $this->createBaseToken($name, $abilities, $expiresAt);

        $token->plainTextToken = Crypt::encryptString($token->plainTextToken);

        return $token;
    }

    public function userCompanies()
    {
        return $this->hasMany(UserCompany::class, UserConstant::USER_ID);
    }

    public function office()
    {
        return $this->belongsTo(Office::class)->select(['id', 'name', 'company_id', 'state', 'country']);
    }

    public function roles()
    {
        return $this->hasManyThrough(Role::class, UserRole::class, 'user_id', 'id', 'id', 'role_id')->select(['roles.id', 'roles.name', 'roles.company_id']);
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
        return $this->hasManyThrough(Department::class, UserDepartment::class, 'user_id', 'id', 'id', 'department_id')->select(['departments.id', 'departments.name', 'departments.company_id']);
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
        return $this->hasManyThrough(Team::class, UserTeam::class, 'user_id', 'id', 'id', 'team_id')->select(['teams.id', 'teams.name', 'teams.company_id', 'teams.team_lead']);
    }

    public function user_teams()
    {
        return $this->hasMany(UserTeam::class, 'user_id');
    }

    public function isActive(): bool
    {
        return $this->status == UserStatusEnum::ACTIVE->value;
    }

    public function isSuspended()
    {
        return $this->status == UserStatusEnum::INACTIVE->value;
    }
}
