<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserInvitationStatusEnum: string
{
    use ListsEnumValues;

    case PENDING = 'Pending';
    case ACCEPTED = 'Accepted';
    case REJECTED = 'Rejected';
}
