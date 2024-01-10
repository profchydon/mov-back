<?php

namespace App\Http\Resources\User;

use App\Models\UserCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSeatResource extends JsonResource
{
    public $collects = UserCompany::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->user->id,
            'firstName' => $this->user->first_name,
            'lastName' => $this->user->last_name,
        ];

        // Check if 'head' relationship was loaded in the query

        // // Check if 'users' relationship was loaded in the query
        // if ($this->relationLoaded('user')) {
        //     $resourceArray['user'] = $this->user
        //         ->load(['user_departments' => function ($query) {
        //             $query->where('department_id', $this->id);
        //         }])
        //         ->load(['teams' => function ($query) {
        //             $query->where('teams.department_id', $this->id);
        //         }]);
        // } else {
        //     $resourceArray['members'] = null;
        //     $resourceArray['memberCount'] = null;
        // }

        return $resourceArray;
    }
}
