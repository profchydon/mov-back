<?php

namespace App\Domains\Enum\User;

use App\Traits\ListsEnumValues;

enum UserStageEnum: string
{
    use ListsEnumValues;

    case VERIFICATION = 'VERIFICATION';
    case COMPANY_DETAILS = 'COMPANY DETAILS';
    case SUBSCRIPTION_PLAN = 'SUBSCRIPTION PLAN';
    case USERS = 'USERS';
    case COMPLETED = 'COMPLETED';
}