<?php

namespace App\Domains\Constant;

use App\Domains\Enum\User\UserInvitationStatusEnum;

class UserInvitationConstant
{
    public const ID = 'id';
    public const EMAIL = 'email';
    public const ROLE_ID = 'role_id';
    public const CODE = 'code';
    public const COMPANY_ID = 'company_id';
    public const INVITED_BY = 'invited_by';
    public const STATUS = 'status';

    public const STATUS_ENUM = [
        UserInvitationStatusEnum::PENDING,
        UserInvitationStatusEnum::ACCEPTED,
        UserInvitationStatusEnum::REJECTED,
    ];
}
