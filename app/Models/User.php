<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use App\Events\UserCreatedEvent;
use App\Events\UserDeactivatedEvent;
use App\Domains\Enum\UserStatusEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
        static::created(function(self $model){
            UserCreatedEvent::dispatch($model);
        });

        static::updated(function(self $model){
            if($model->status == UserStatusEnum::DEACTIVATED){
                UserDeactivatedEvent::dispatch($model);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
