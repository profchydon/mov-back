<?php

namespace App\Domains\Enum\Asset;

use App\Traits\ListsEnumValues;

enum AssetStatusEnum: string
{
    use ListsEnumValues;

    case PENDING_APPROVAL = 'PENDING APPROVAL';
    case AVAILABLE = 'AVAILABLE';
    case CHECKED_OUT = 'CHECKED OUT';
    case TRANSFERRED = 'TRANSFERRED';
    case ARCHIVED = 'ARCHIVED';
    case STOLEN = 'STOLEN';
    case DAMAGED = 'DAMAGED';
}
