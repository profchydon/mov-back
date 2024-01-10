<?php

namespace App\Domains\Enum\Invoice;

use App\Traits\ListsEnumValues;

enum InvoiceItemTypeEnum: string
{
    use ListsEnumValues;

    case SUBSCRIPTION = 'Subscription';
    case ADDON = 'Addon';
}
