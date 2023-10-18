<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetCheckoutStatusEnum: string
{
    use ListsEnumValues;

    case CHECKED_OUT = 'CHECKED_OUT';
    case OVERDUE = 'OVERDUE';
    case RETURNED = 'RETURNED';
}
