<?php

namespace App\Http\Resources\Company;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUserResource extends JsonResource
{
    public $collects = User::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'lastLogin' => $this->last_login,
            'jobTitle' => $this->job_title,
            'stage' => $this->stage,
            'status' => $this->status,
            // 'country' => $this->country ? [
            //     'id' => $this->country->id,
            //     'name' => $this->country->name,
            // ] : null,
        ];

        // Check if 'department' relationship was loaded in the query
        if ($this->relationLoaded('department')) {
            $resourceArray['department'] = $this->department;
            $resourceArray['memberCount'] = $this->departments->count();
        } else {
            $resourceArray['department'] = null;
            $resourceArray['memberCount'] = null;
        }

        // Check if 'department' relationship was loaded in the query
        if ($this->relationLoaded('teams')) {
            $resourceArray['teams'] = $this->teams;
            $resourceArray['teamCount'] = $this->teams->count();
        } else {
            $resourceArray['teams'] = null;
            $resourceArray['teamCount'] = null;
        }

        if ($this->relationLoaded('office')) {
            $resourceArray['office'] = [
                'id' => $this->office?->id,
                'name' => $this->office?->name,
            ];
        } else {
            $resourceArray['office'] = null;
        }

        return $resourceArray;
    }
}
