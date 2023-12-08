<?php

namespace App\Http\Resources;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public $collects = Department::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'company' => [
                'id' => $this->company_id,
                'name' => $this->company?->name,
            ],
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Check if 'head' relationship was loaded in the query
        if ($this->relationLoaded('head')) {
            $resourceArray['head'] = [
                'name' => $this->head?->first_name . ' ' . $this->head?->last_name,
                'id' => $this->head?->id,
            ];
        } else {
            $resourceArray['head'] = null;
        }

        // Check if 'members' relationship was loaded in the query
        if ($this->relationLoaded('members')) {
            $resourceArray['members'] = $this->members
                ->load(['user_departments' => function ($query) {
                    $query->where('department_id', $this->id);
                }])
                ->load(['teams' => function ($query) {
                    $query->where('teams.department_id', $this->id);
                }]);

            $resourceArray['memberCount'] = $this->members->count();
        } else {
            $resourceArray['members'] = null;
            $resourceArray['memberCount'] = null;
        }

        // Check if 'teams' relationship was loaded in the query
        if ($this->relationLoaded('teams')) {
            $resourceArray['teams'] = $this->teams->each(function () {
            });
            $resourceArray['teamCount'] = $this->teams->count();
        } else {
            $resourceArray['teams'] = null;
            $resourceArray['teamCount'] = null;
        }

        return $resourceArray;
    }
}
