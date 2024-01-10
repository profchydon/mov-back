<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserInvitationStatusEnum: string
{
    use ListsEnumValues;

    case PENDING = 'PENDING';
    case ACCEPTED = 'ACCEPTED';
    case REJECTED = 'REJECTED';
}
