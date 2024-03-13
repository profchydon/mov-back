<?php

namespace App\Http\Resources\Plan;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public $collects = Plan::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'name' => $this->name,
            'offers' => $this->offers,
            'status' => $this->status,
        ];

        return $resourceArray;
    }
}
