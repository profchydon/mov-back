<?php

namespace App\Domains\DTO\Invoice;

use App\Traits\DTOToArray;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class InvoiceItemDTO
{
    use DTOToArray;

    private string $invoice_id;
    private float $quantity;
    private float $amount;
    private Model $item;
    private string $item_type;
    private string $item_id;

    public function getInvoiceId(): string
    {
        return $this->invoice_id;
    }

    public function setInvoiceId(string $invoice_id): InvoiceItemDTO
    {
        $this->invoice_id = $invoice_id;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): InvoiceItemDTO
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): InvoiceItemDTO
    {
        $this->amount = $amount;
        return $this;
    }

    public function getItem(): Model
    {
        return $this->item;
    }

    public function setItem(Model $item): InvoiceItemDTO
    {
        $this->item = $item;
        $this->item_id = $item->id;
        $this->item_type = $item::class;
        return $this;
    }



}
