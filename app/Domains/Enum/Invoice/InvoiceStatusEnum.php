<?php

namespace App\Domains\Enum\Invoice;

use App\Traits\ListsEnumValues;

enum InvoiceStatusEnum: string
{
    use ListsEnumValues;

    case PENDING = 'Pending';
    case PAID = 'Paid';
    case OVERDUE = 'Overdue';
    case CANCELED = 'Canceled';
}
