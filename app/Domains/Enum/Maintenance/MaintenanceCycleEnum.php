<?php

namespace App\Domains\Enum\Maintenance;

use App\Traits\ListsEnumValues;

enum MaintenanceCycleEnum: string
{
    use ListsEnumValues;

    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';
    case BI_WEEKLY = 'BI-WEEKLY';
    case MONTHLY = 'MONTHLY';
    case BI_MONTHLY = 'BI-MONTHLY';
    case YEARLY = 'YEARLY';
}
