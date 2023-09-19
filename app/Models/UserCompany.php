<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'tenant_id',
        'company_id',
        'user_id',
        'status',
    ];
}
