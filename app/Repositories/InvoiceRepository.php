<?php

namespace App\Repositories;

use App\Domains\Enum\PaymentStatusEnum;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Repositories\Contracts\InvoicePaymentRepositoryInterface;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use App\Services\V2\FlutterwaveService;
use App\Services\V2\StripeService;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceRepository implements InvoiceRepositoryInterface, InvoicePaymentRepositoryInterface
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

    public function verifyPayment(InvoicePayment|string $payment)
    {

        if (!($payment instanceof  InvoicePayment)) {
            $payment = InvoicePayment::where('tx_ref', $payment)->first();
        }

        if ($payment->processor == 'flutterwave') {
            if (!$this->verifyFlwTransaction($payment->tx_ref)) {
                return false;
            }
        }

        if ($payment->processor == 'stripe') {
            if (!$this->verifyStripeTransaction($payment->tx_ref)) {
                return false;
            }
        }

        if ($payment->status != PaymentStatusEnum::COMPLETED->value) {
            $payment->complete();
        }

        return true;
    }

    public function verifyFlwTransaction($tx_ref)
    {

        $verifiedTransaction = FlutterwaveService::getTransactionDetails($tx_ref);

        if ($verifiedTransaction['status'] = !'success') {

            return false;
        }

        if ($verifiedTransaction['data']['status'] != 'successful') {
            return false;
        }

        return true;
    }

    public function verifyStripeTransaction($tx_ref)
    {

        return true;
    }
}
