<?php

namespace App\Models;

use App\Domains\Constant\UserCompanyConstant;
use App\Domains\Constant\UserConstant;
use App\Traits\HasCompany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory, HasUuids, HasCompany;

    protected $guarded = [
        UserCompanyConstant::ID,
    ];

    protected $casts = [
        UserCompanyConstant::ID => 'string',
        UserCompanyConstant::USER_ID => 'string',
        UserCompanyConstant::COMPANY_ID => 'string',
    ];

    protected $hidden = [
        UserCompanyConstant::TENANT_ID,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, UserConstant::USER_ID);
    }
}
