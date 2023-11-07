<?php

namespace App\Http\Resources;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;

class DepartmentResource extends JsonResource
{
    public $collects = Department::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'company' => [
                'id' => $this->company_id,
                'name' => $this->company?->name,
            ],
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'head' => $this->head ? [
                'name' => $this->head?->first_name . ' ' . $this->head?->last_name,
                'id' => $this->head?->id,
            ] : null,
            'members' => $this->members
                ->load(['user_departments' => function ($query) {
                    $query->where('department_id', $this->id);
                }])
                ->load(['teams' => function ($query) {
                    $query->where('teams.department_id', $this->id);
                }]),
            'memberCount' => $this->members->count(),
            'teamCount' => $this->teams->count(),
        ];
    }
}
