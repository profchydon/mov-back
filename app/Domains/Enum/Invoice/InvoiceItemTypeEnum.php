<?php

namespace App\Domains\Enum\Invoice;

use App\Traits\ListsEnumValues;

enum InvoiceItemTypeEnum: string
{
    use ListsEnumValues;

    case SUBSCRIPTION = 'SUBSCRIPTION';
    case ADDON = 'ADDON';

}
