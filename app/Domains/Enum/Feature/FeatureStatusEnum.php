<?php

namespace App\Domains\Enum\Feature;

use App\Traits\ListsEnumValues;

enum FeatureStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
