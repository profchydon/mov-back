<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetMaintenanceStatusEnum: string
{
    use ListsEnumValues;

    case CHECKED_OUT = 'CHECKED OUT';
    case OVERDUE = 'OVERDUE';
    case RETURNED = 'RETURNED';
    case LOGGED = 'LOGGED';
}
