<?php

namespace App\Http\Resources\Office;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfficeResource extends JsonResource
{
    public $collects = Office::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'streetAddress' => $this->street_address,
            'state' => $this->state,
            'country' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'currencyCode' => $this->currency_code,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'company' => [
                'id' => $this->company_id,
                'name' => $this->company?->name,
            ],
            // 'areas' => $this->areas
            //     ->load(['user_departments' => function ($query) {
            //         $query->where('department_id', $this->id);
            //     }])
            //     ->load(['teams' => function ($query) {
            //         $query->where('teams.department_id', $this->id);
            //     }]),
            'assetCount' => $this->assets->count(),
            // 'teamCount' => $this->teams->count(),
        ];
    }
}
