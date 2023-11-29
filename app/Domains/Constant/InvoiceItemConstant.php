<?php

namespace App\Domains\Constant;

use App\Domains\Enum\Invoice\InvoiceItemTypeEnum;

/**
 * Class InvoiceItemConstant.
 */
class InvoiceItemConstant
{
    public const ID = 'id';
    public const INVOICE_ID = 'invoice_id';
    public const ITEM = 'item';
    public const ITEM_TYPE = 'item_type';
    public const ITEM_ID = 'item_id';
    public const QUANTITY = 'quantity';
    public const AMOUNT = 'amount';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';
    public const DELETED_AT = 'deleted_at';


    public const INVOICE_ITEM_TYPE_ENUM = [
        InvoiceItemTypeEnum::SUBSCRIPTION,
        InvoiceItemTypeEnum::ADDON,
    ];
}
