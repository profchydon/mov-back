<?php

namespace App\Repositories\Contracts;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoicePayment;

interface InvoicePaymentRepositoryInterface
{
    public function verifyPayment(string|InvoicePayment $tx_ref);

}
