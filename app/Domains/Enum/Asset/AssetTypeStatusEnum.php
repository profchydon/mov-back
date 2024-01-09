<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetTypeStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
}
