<?php

namespace App\Http\Resources\Company;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUserResource extends JsonResource
{

    public $collects = User::class;

    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'lastLogin' => $this->last_login,
            'jobTitle' => $this->job_title,
            'stage'=> $this->stage,
            'status' => $this->status,
            'country' => $this->country ? [
                'id' => $this->country->id,
                'name' => $this->country->name
            ] : null,
            'department' => $this->departments ? [
                'id' => $this->departments->id,
                'name' => $this->departments->name
            ] : null,
            'teams' => $this->teams ? [
                'id' => $this->teams->id,
                'name' => $this->teams->name
            ] : null,
            'memberCount' => $this->departments->count(),
            'teamCount' => $this->teams->count(),
        ];
    }

}
