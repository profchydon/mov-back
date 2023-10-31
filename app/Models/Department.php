<?php

namespace App\Models;

use App\Domains\Constant\DepartmentConstant;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function members(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }
}
