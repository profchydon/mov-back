<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Invoice\InvoiceStatusEnum;

/**
 * Class InvoiceConstant.
 */
class InvoiceConstant
{
    public const ID = 'id';
    public const TENANT_ID = 'tenant_id';
    public const COMPANY_ID = 'company_id';
    public const INVOICE_NUMBER = 'invoice_number';
    public const DATE_ISSUED = 'date_issued';
    public const DUE_DATE = 'due_date';
    public const SUB_TOTAL = 'sub_total';
    public const TAX = 'tax';
    public const TRANSACTION_REF = 'transaction_ref';
    public const CURRENCY_ID = 'currency_id';
    public const STATUS = 'status';
    public const PAID_AT = 'paid_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const STATUS_ENUM = [
        InvoiceStatusEnum::PENDING,
        InvoiceStatusEnum::PAID,
        InvoiceStatusEnum::OVERDUE,
    ];
}
