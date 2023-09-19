<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
    case DEACTIVATED = 'DEACTIVATED';
}
