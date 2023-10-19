<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserRoleStatusEnum: string
{
    use ListsEnumValues;

    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
