<?php

namespace App\Models;

use App\Domains\Constant\UserTeamConstant;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserTeam extends BaseModel
{
    use HasFactory, HasUuids;

    protected $guarded = [
        UserTeamConstant::ID,
    ];

    protected $casts = [
        UserTeamConstant::ID => 'string',
        UserTeamConstant::USER_ID => 'string',
        UserTeamConstant::DEPARTMENT_ID => 'string',
        UserTeamConstant::COMPANY_ID => 'string',
        UserTeamConstant::TEAM_ID => 'string',
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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
