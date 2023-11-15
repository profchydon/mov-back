<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
}
