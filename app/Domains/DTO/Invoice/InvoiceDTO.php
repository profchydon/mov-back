<?php

namespace App\Domains\DTO\Invoice;

use App\Traits\DTOToArray;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

final class InvoiceDTO
{
    use DTOToArray;

    private string $tenant_id;
    private string $company_id;
    private Carbon $due_at;
    private float $sub_total;
    private float $tax = 0;
    private string $currency_code;
    private string $status;
    private Carbon $paid_at;
    private Model $billable;
    private string $billable_type;
    private string $billable_id;

    public function getTenantId(): string
    {
        return $this->tenant_id;
    }

    public function setTenantId(string $tenant_id): InvoiceDTO
    {
        $this->tenant_id = $tenant_id;
        return $this;
    }

    public function getCompanyId(): string
    {
        return $this->company_id;
    }

    public function setCompanyId(string $company_id): InvoiceDTO
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function getDueAt(): Carbon
    {
        return $this->due_at;
    }

    public function setDueAt(Carbon $due_at): InvoiceDTO
    {
        $this->due_at = $due_at;
        return $this;
    }

    public function getSubTotal(): float
    {
        return $this->sub_total;
    }

    public function setSubTotal(float $sub_total): InvoiceDTO
    {
        $this->sub_total = $sub_total;
        return $this;
    }

    public function getTax(): float
    {
        return $this->tax;
    }

    public function setTax(float $tax): InvoiceDTO
    {
        $this->tax = $tax;
        return $this;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    public function setCurrencyCode(string $currency_code): InvoiceDTO
    {
        $this->currency_code = $currency_code;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): InvoiceDTO
    {
        $this->status = $status;
        return $this;
    }

    public function getPaidAt(): Carbon
    {
        return $this->paid_at;
    }

    public function setPaidAt(Carbon $paid_at): InvoiceDTO
    {
        $this->paid_at = $paid_at;
        return $this;
    }

    public function getBillable(): Model
    {
        return $this->billable;
    }

    public function setBillable(Model $billable): InvoiceDTO
    {
        $this->billable = $billable;
        $this->billable_id = $billable->id;
        $this->billable_type = $billable::class;

        return $this;
    }

    public function getBillableType(): string
    {
        return $this->billable_type;
    }

    public function getBillableId(): string
    {
        return $this->billable_id;
    }

}
