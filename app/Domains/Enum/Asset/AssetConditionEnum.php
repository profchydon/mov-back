<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetConditionEnum: string
{
    use ListsEnumValues;

    case WORKING_PERFECTLY = 'Working Perfectly';
    case MISSING_INFORMATION = 'Missing Information';
    case MAINTENANCE_CRITICAL = 'Maintenance Critical';
    case MAINTENANCE_OVERDUE = 'Maintenance Overdue';
    case FAULTY = 'Faulty';
}
