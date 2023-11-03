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

    public const NAME = 'name';
    public const JOB_TITLE = 'job_title';
    public const EMPLOYMENT_TYPE = 'employment_type';
    public const OFFICE_ID = 'office_id';
    public const DEPARTMENT_ID = 'department_id';
    public const TEAM = 'team';

    public const STATUS_ENUM = [
        UserInvitationStatusEnum::PENDING,
        UserInvitationStatusEnum::ACCEPTED,
        UserInvitationStatusEnum::REJECTED,
    ];
}
