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
            'companyId' => $this->company_id,
            'name' => $this->name,
            'createdBy' => $this->createdBy ? [
                'id' => $this->createdBy?->id,
                'firstName' => $this->createdBy?->first_name,
                'lastName' => $this->createdBy?->last_name,
            ] : null,
            'status' => $this->status,
            'notes' => $this->notes,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];

        $resourceArray['assets'] = null;
        $resourceArray['assetCount'] = null;

        // Check if 'assets' relationship was loaded in the query
        if ($this->relationLoaded('assets')) {
            $resourceArray['assets'] = $this->assets->map(function ($asset) {
                return new AssetResource($asset);
            });
            $resourceArray['assetCount'] = $this->assets->count();
        }

        if ($this->relationLoaded('assetCountOnly')) {
            $resourceArray['assetCount'] = $this->assets->count();
        }

        return $resourceArray;
    }
}
