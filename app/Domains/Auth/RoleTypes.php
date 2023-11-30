<?php

namespace App\Domains\Auth;

enum RoleTypes: string
{
    case SUPER_ADMINISTRATOR = 'Super Administrator';
    case ADMINISTRATOR = 'Administrator';
    case MANAGER = 'Manager';
    case GUEST = 'Guest';
    case BASIC = 'Basic';
}
