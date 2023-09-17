<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserStageEnum: string
{
    use ListsEnumValues;

    case START = 'START';
    case ASSET = 'ASSET';
    case USER = 'USER';
}
