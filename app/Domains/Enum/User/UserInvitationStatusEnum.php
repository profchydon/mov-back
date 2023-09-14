<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserInvitationStatusEnum: string
{
    use ListsEnumValues;

    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
}
