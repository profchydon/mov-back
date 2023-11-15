<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function getCompanyInvoices(Company|string $company)
    {
        if (!($company instanceof  Company)) {
            $company = Company::findOrFail($company);
        }

        $invoices = $company->invoices()->withCount('items');
        $invoices = Invoice::appendToQueryFromRequestQueryParameters($invoices);

        return $invoices->paginate();
    }

    public function getCompanyInvoice(Invoice|string $invoice)
    {
        if (!($invoice instanceof  Invoice)) {
            $invoice = Company::findOrFail($invoice);
        }

        return $invoice->load('currency', 'items.item');
    }

    public function generateInvoicePDF(Invoice|string $invoice)
    {
        if (!($invoice instanceof  Invoice)) {
            $invoice = Invoice::findOrFail($invoice);
        }

        $invoice->load('items.item', 'company');

        $fileName = "invoices/{$invoice->invoice_number}.pdf";

        $html = view('pdfs.invoice', compact('invoice'))->render();
        $pdf = Pdf::loadHTML($html);
        $pdf->setOption('dpi', 150);
        $pdf->setOption('defaultFont', 'sans-serif');
        $pdf->save(public_path($fileName));

        return url($fileName);
    }
}
