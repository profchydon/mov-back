<?php

namespace App\Models;

use App\Domains\Constant\UserDepartmentConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDepartment extends BaseModel
{
    use HasFactory, HasUuids;

    protected $guarded = [
        UserDepartmentConstant::ID,
    ];

    protected $casts = [
        UserDepartmentConstant::ID => 'string',
        UserDepartmentConstant::USER_ID => 'string',
        UserDepartmentConstant::DEPARTMENT_ID => 'string',
        UserDepartmentConstant::COMPANY_ID => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
