<?php

namespace App\Models;

use App\Domains\Constant\DepartmentConstant;
use App\Traits\QueryFormatter;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Department extends BaseModel
{
    use UsesUUID, QueryFormatter;

    protected static $searchable = [
        'name',
    ];

    protected $hidden = [
        DepartmentConstant::HEAD_ID,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_id');
    }
}
