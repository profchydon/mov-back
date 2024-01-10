<?php

namespace App\Domains\Enum\Invoice;

use App\Traits\ListsEnumValues;

enum InvoiceStatusEnum: string
{
    use ListsEnumValues;

    case PENDING = 'PENDING';
    case PAID = 'PAID';
    case OVERDUE = 'OVERDUE';
}
