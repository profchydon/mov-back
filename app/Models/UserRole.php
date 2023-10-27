<?php

namespace App\Models;

use App\Domains\Constant\UserRoleConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRole extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [

    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, UserRoleConstant::COMPANY_ID);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, UserRoleConstant::ROLE_ID);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, UserRoleConstant::USER_ID);
    }

    protected static function booted()
    {
    }
}
