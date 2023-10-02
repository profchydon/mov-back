<?php

namespace App\Domains\DTO;

use App\Traits\DTOToArray;
use Illuminate\Support\Carbon;

class CreateSubscriptionDTO
{
    use DTOToArray;

    private string $tenant_id;
    private string $company_id;
    private string $plan_id;
    private string $invoice_id;
    private Carbon $start_date;
    private Carbon $end_date;
    private string $billing_cycle;
    private string $status;

    public function setTenantId(string $tenant_id)
    {
        $this->tenant_id = $tenant_id;

        return $this;
    }

    public function getTenantId()
    {
        return $this->tenant_id;
    }

    public function setCompanyId(string $company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getCompanyId()
    {
        return $this->company_id;
    }

    public function setPlanId(string $plan_id)
    {
        $this->plan_id = $plan_id;

        return $this;
    }

    public function getPlanId()
    {
        return $this->plan_id;
    }

    public function setInvoiceId(string $invoice_id)
    {
        $this->invoice_id = $invoice_id;

        return $this;
    }

    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    public function setStartDate(Carbon $start_date)
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function setEndDate(Carbon $end_date)
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setBillingCycle(string $billing_cycle)
    {
        $this->billing_cycle = $billing_cycle;

        return $this;
    }

    public function getBillingCycle()
    {
        return $this->billing_cycle;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
