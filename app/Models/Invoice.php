<?php

namespace App\Models;

use App\Domains\Constant\InvoiceConstant;
use App\Domains\Enum\Invoice\InvoiceStatusEnum;
use App\Traits\UsesUUID;

class Invoice extends BaseModel
{
    use UsesUUID;

    protected $guarded = [
        InvoiceConstant::ID,
    ];

    protected $casts = [
        InvoiceConstant::ID => 'string',
        InvoiceConstant::STATUS => InvoiceStatusEnum::class,
        InvoiceConstant::DUE_AT => 'datetime',
        InvoiceConstant::PAID_AT => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (self $model) {
            $invoiceNumber = chunk_split(strtoupper(uniqid('in')), 5, '-');
            $invoiceNumber = trim($invoiceNumber, '-');
            $model->invoice_number = $invoiceNumber;
        });
    }

    public function billable()
    {
        return $this->morphTo();
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_code', 'code');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
