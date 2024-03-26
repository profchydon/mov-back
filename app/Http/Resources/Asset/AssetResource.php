<?php

namespace App\Http\Resources\Asset;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    public $collects = Asset::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'make' => $this->make,
            'model' => $this->model,
            'serialNumber' => $this->serial_number,
            'purchasePrice' => $this->purchase_price,
            'purchaseDate' => $this->purchase_date,
            'currency' => $this->currency,
            'addedAt' => $this->added_at,
            'condition' => $this->condition,
            'nextMaintenanceDate' => $this->next_maintenance_date,
            'isInsured' => $this->is_insured,
            'acquisitionType' => $this->acquisition_type,
            'maintenanceCycle' => $this->maintenance_cycle,
            'status' => $this->status,
            'office' => $this->office ? [
                'id' => $this->office?->id,
                'name' => $this->office?->name,
                'address' => $this->office?->address,
            ] : null,
            'vendor' => $this->vendor ? [
                'id' => $this->vendor?->id,
                'name' => $this->vendor?->name,
                'email' => $this->vendor?->email,
                'phone' => $this->vendor?->phone,
                'address' => $this->vendor?->address,
            ] : null,
            'type' => $this->type ? [
                'id' => $this->type?->id,
                'name' => $this->type?->name,
            ] : null,
            'assignee' => $this->assignee ? [
                'id' => $this->assignee?->id,
                'firstName' => $this->assignee?->first_name,
                'lastName' => $this->assignee?->last_name,
            ] : null,
        ];
    }
}
