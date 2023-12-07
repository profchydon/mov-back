<?php

namespace App\Http\Resources\Vendor;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    public $collects = Vendor::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Check if 'assets' relationship was loaded in the query
        if ($this->relationLoaded('assets')) {
            $resourceArray['assets'] = $this->assets->load('office');
            $resourceArray['assetCount'] = $this->assets->count();
        } else {
            $resourceArray['assets'] = null;
            $resourceArray['assetCount'] = null;
        }

        return $resourceArray;
    }
}
