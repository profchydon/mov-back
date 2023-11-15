<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function getCompanyInvoices(string|Company $company);

    public function getCompanyInvoice(string|Invoice $invoice);

    public function generateInvoicePDF(string|Invoice $invoice);
}
