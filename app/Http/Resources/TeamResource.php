<?php

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public $collects = Team::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company' => [
                'id' => $this->company?->id,
                'name' => $this->company?->name,
            ],
            'department' => [
                'id' => $this->department?->id,
                'name' => $this->department?->name,
            ],
            'team_lead' => $this->teamLead ? [
                'name' => $this->teamLead?->first_name . ' ' . $this->teamLead?->last_name,
                'id' => $this->teamLead?->id,
            ] : null,
            // 'members' => $this->members
            //     ->load('user_teams'),
            'memberCount' => $this->members->count(),
        ];
    }
}
