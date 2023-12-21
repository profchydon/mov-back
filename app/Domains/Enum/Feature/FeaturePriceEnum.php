<?php

namespace App\Domains\Enum\Feature;

use App\Traits\ListsEnumValues;

enum FeaturePriceEnum: string
{
    use ListsEnumValues;

    case FREE = 'Free';
    case PAID = 'Paid';
}
