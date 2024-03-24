<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends BaseModel
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
