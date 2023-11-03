<?php

namespace App\Models;

use App\Domains\Constant\DepartmentConstant;
use App\Domains\Constant\UserDepartmentConstant;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Department extends BaseModel
{
    use UsesUUID, HasCompany;

    protected static $searchable = [
        'name',
    ];

    protected $hidden = [
        DepartmentConstant::HEAD_ID,
    ];

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserDepartment::class, 'department_id', 'id', 'id', 'user_id');
    }

    
}
