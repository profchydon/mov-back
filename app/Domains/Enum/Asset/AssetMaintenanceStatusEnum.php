<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetMaintenanceStatusEnum: string
{
    use ListsEnumValues;

    case CHECKED_OUT = 'Checked Out';
    case OVERDUE = 'Overdue';
    case RETURNED = 'Returned';
    case LOGGED = 'Logged';
}
