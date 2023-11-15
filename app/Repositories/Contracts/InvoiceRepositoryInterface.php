<?php

namespace App\Repositories\Contracts;

use App\Models\Company;

interface InvoiceRepositoryInterface
{
    public function getCompanyInvoices(string|Company $company);
}
