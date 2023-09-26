<?php

namespace App\Models;

use App\Domains\Constant\UserCompanyConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [
        UserCompanyConstant::ID,
    ];
}
