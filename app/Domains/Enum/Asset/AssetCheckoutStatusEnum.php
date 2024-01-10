<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetCheckoutStatusEnum: string
{
    use ListsEnumValues;

    case CHECKED_OUT = 'Checked Out';
    case OVERDUE = 'Overdue';
    case RETURNED = 'Returned';
}
