<?php

namespace App\Models;

use App\Domains\Constant\TeamConstant;
use App\Traits\HasCompany;
use App\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Team extends BaseModel
{
    use UsesUUID, HasCompany;

    protected static $searchable = [
        'name',
    ];

    protected $hidden = [
        TeamConstant::TENANT_ID,
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function teamLead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_lead');
    }

    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserTeam::class, 'team_id', 'id', 'id', 'user_id');
    }
}
