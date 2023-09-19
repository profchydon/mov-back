<?php

namespace App\Models;

use App\Domains\Constant\UserConstant;
use App\Traits\GetsTableName;
use App\Events\UserCreatedEvent;
use Laravel\Sanctum\HasApiTokens;
use App\Events\UserDeactivatedEvent;
use Illuminate\Notifications\Notifiable;
use App\Domains\Enum\User\UserStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, GetsTableName;

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
        UserConstant::PASSWORD,
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
        parent::boot();

        static::created(function(self $model){
            // UserCreatedEvent::dispatch($model);
        });

        static::updated(function(self $model){
            if($model->status == UserStatusEnum::DEACTIVATED){
                // UserDeactivatedEvent::dispatch($model);
            }
        });

        self::creating(function ($model) {
            $model->id = (string) Uuid::uuid4();
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
