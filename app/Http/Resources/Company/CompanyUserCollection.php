<?php

namespace App\Http\Resources\Company;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CompanyUserCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => CompanyResource::collection($this->collection),
            'total' => $this->total(),
            'per_page' => $this->perPage(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
        ];
    }
}
