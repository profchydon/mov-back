<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetConditionEnum: string
{
    use ListsEnumValues;

    case WORKING_PERFECTLY = 'WORKING PERFECTLY';
    case MISSING_INFORNATION = 'MISSING INFORNATION';
    case MAINTENANCE_CRITICAL = 'MAINTENANCE CRITICAL';
    case MAINTENANCE_OVERDUE = 'MAINTENANCE OVERDUE';
    case FAULTY = 'FAULTY';
}
