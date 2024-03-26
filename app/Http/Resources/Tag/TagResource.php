<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\Asset\AssetResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    public $collects = Tag::class;

    public function toArray(Request $request)
    {
        $resourceArray = [
            'id' => $this->id,
            'company_id' => $this->company_id,
            'name' => $this->name,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        // Check if 'assets' relationship was loaded in the query
        if ($this->relationLoaded('assets')) {
            $resourceArray['assets'] = $this->assets->map(function ($asset) {
                return new AssetResource($asset);
            });
            $resourceArray['assetCount'] = $this->assets->count();
        } else {
            $resourceArray['assets'] = null;
            $resourceArray['assetCount'] = null;
        }

        // if ($this->relationLoaded('company')) {
        //     $resourceArray['company'] = $this->company;
        // } else {
        //     $resourceArray['company'] = null;
        // }

        return $resourceArray;
    }
}
