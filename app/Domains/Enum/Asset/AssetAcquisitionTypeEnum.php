<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetAcquisitionTypeEnum: string
{
    use ListsEnumValues;

    case BRAND_NEW = 'BRAND NEW';
    case REFURBISHED = 'REFURBISHED';
    case USED = 'USED';
}
