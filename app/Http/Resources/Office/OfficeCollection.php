<?php

namespace App\Http\Resources\Office;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OfficeCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => OfficeResource::collection($this->collection),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
        ];
    }
}
