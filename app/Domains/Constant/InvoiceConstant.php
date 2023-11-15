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
    public const DUE_AT = 'due_at';
    public const SUB_TOTAL = 'sub_total';
    public const TAX = 'tax';
    public const CURRENCY_CODE = 'currency_code';
    public const STATUS = 'status';
    public const PAID_AT = 'paid_at';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';
    public const BILLABLE = 'billable';
    public const BILLABLE_TYPE = 'billable_type';
    public const BILLABLE_ID = 'billable_id';


    public const STATUS_ENUM = [
        InvoiceStatusEnum::PENDING,
        InvoiceStatusEnum::PAID,
        InvoiceStatusEnum::OVERDUE,
    ];
}
