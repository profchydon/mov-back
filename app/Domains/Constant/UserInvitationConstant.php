<?php

namespace App\Domains\Constant;

use App\Domains\Enum\User\UserInvitationStatusEnum;

class UserInvitationConstant
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const ROLE = 'role';
    public const CODE = 'code';
    public const STATUS = 'status';

    public const STATUS_ENUM = [
        UserInvitationStatusEnum::PENDING,
        UserInvitationStatusEnum::ACCEPTED,
        UserInvitationStatusEnum::REJECTED,
    ];
}
