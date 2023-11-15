<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{

    public function getCompanyInvoices(Company|string $company)
    {
        if (!($company instanceof  Company)){
            $company = Company::findOrFail($company);
        }

        $invoices = $company->invoices()->withCount('items');
        $invoices = Invoice::appendToQueryFromRequestQueryParameters($invoices);

        return $invoices->paginate();
    }
}
