<?php

namespace App\Domains\Enum;

use App\Traits\ListsEnumValues;

enum UserStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case DEACTIVATED = 'DEACTIVATED';
}
