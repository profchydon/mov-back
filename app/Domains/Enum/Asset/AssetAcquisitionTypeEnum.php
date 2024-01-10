<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetAcquisitionTypeEnum: string
{
    use ListsEnumValues;

    case BRAND_NEW = 'Brand New';
    case REFURBISHED = 'Refurbished';
    case USED = 'Used';
}
