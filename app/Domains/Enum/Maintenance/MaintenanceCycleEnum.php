<?php

namespace App\Domains\Enum\Maintenance;

use App\Traits\ListsEnumValues;

enum MaintenanceCycleEnum: string
{
    use ListsEnumValues;

    case DAILY = 'Daily';
    case WEEKLY = 'Weekly';
    case BI_WEEKLY = 'Bi-weekly';
    case MONTHLY = 'Monthly';
    case BI_MONTHLY = 'Bi-monthly';
    case YEARLY = 'Yearly';
}
