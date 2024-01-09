<?php

namespace App\Models;

use App\Domains\Constant\UserInvitationConstant;
use App\Events\User\UserInvitationCreatedEvent;
use App\Traits\HasCompany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class UserInvitation extends BaseModel
{
    use HasFactory, HasUuids, HasCompany;

    protected $guarded = [
        UserInvitationConstant::ID,
    ];

    protected static $filterable = [
        'department' => 'user_invitations.department_id',
        'role' => 'user_invitations.role_id',
        'office' => 'user_invitations.office_id',
    ];

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted()
    {
        static::created(function (self $model) {
            Log::info("Dispatching event... User Invitation: {$model->email} {$model}");
            UserInvitationCreatedEvent::dispatch($model);
            Log::info("User Invitation event dispatched: {$model->email} {$model}");
        });
    }
}
