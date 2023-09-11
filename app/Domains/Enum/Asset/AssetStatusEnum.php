<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetStatusEnum: string
{
    use ListsEnumValues;

    case TRANSFERRED = 'TRANSFERRED';


}
