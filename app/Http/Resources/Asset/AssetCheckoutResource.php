<?php

namespace App\Http\Resources\Asset;

use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetCheckoutResource extends JsonResource
{
    public $collects = Office::class;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assetId' => $this->asset_id,
            'groupId' => $this->group_id,
            'reason' => $this->reason,
            'status' => $this->status,
            'comment' => $this->comment,
            'checkoutDate' => $this->checkout_date,
            'checkoutBy' => $this->checkout_by,
            'returnBy' => $this->return_by,
            'returnDate' => $this->return_date,
            'dateReturned' => $this->date_returned,
            'receiver' => $this->receiver && $this->receiver_type === "App\Models\User"  ? [
                'id' => $this->receiver?->id,
                'name' => $this->receiver?->first_name . ' ' . $this->receiver?->last_name,
            ] : [
                'id' => $this->receiver?->id,
                'name' => $this->receiver?->name,
            ],
            'checkedOutBy' => $this->checkedOutBy ? [
                'id' => $this->head?->id,
                'firstName' => $this->checkedOutBy?->first_name,
                'lastName' => $this->checkedOutBy?->last_name,
            ] : null,
            'asset' => $this->asset ? [
                'id' => $this->asset?->id,
                'make' => $this->asset?->make,
                'model' => $this->asset?->model,
                'serialNumber' => $this->asset?->serial_number,
                'purchasePrice' => $this->asset?->purchase_price,
                'purchaseDate' => $this->asset?->purchase_date,
                'currency' => $this->asset?->currency,
                'status' => $this->asset?->status,
                'office' => $this->asset?->office ? [
                    'id' =>  $this->asset?->office?->id,
                    'name' => $this->asset?->office?->name,
                    'address' => $this->asset?->office?->address,
                ] : null,
                'assignee' => $this->asset?->assignee ? [
                    'id' =>  $this->asset?->assignee?->id,
                    'firstName' => $this->asset?->assignee?->first_name,
                    'lastName' => $this->asset?->assignee?->last_name,
                ] : null,
            ] : null,
        ];
    }
}
