<?php

namespace App\Domains\Enum\Feature;

use App\Traits\ListsEnumValues;

enum FeatureStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
