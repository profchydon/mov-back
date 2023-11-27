<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceRepositoryInterface $invoiceRepository)
    {
    }

    public function index(Company $company, Request $request)
    {
        $invoices = $this->invoiceRepository->getCompanyInvoices($company);

        return $this->response(Response::HTTP_OK, __('messages.records-fetched'), $invoices);
    }

    public function show(Company $company, Invoice $invoice)
    {
        $invoice = $this->invoiceRepository->getCompanyInvoice($invoice);

        return $this->response(Response::HTTP_OK, __('messages.record-fetched'), $invoice);
    }

    public function showPDF(Company $company, Invoice $invoice)
    {
        $pdfLink = $this->invoiceRepository->generateInvoicePDF($invoice);

        return $this->response(Response::HTTP_OK, __('message.record-fetched'), ['link' => $pdfLink]);
    }
}
