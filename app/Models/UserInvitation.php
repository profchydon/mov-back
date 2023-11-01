<?php

namespace App\Models;

use App\Domains\Constant\UserInvitationConstant;
use App\Events\User\UserInvitationCreatedEvent;
use App\Traits\HasCompany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class UserInvitation extends Model
{
    use HasFactory, HasUuids, HasCompany;

    protected $guarded = [
        UserInvitationConstant::ID,
    ];

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by');
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
