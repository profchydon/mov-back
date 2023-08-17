<?php

namespace App\Domains\Auth;

enum RoleTypes: string
{
    case ADMINISTRATOR = 'Administrator';
    case ASSET_MANAGER = 'Asset Manager';
    case TECHNICIAN = 'Technician';
    case FINANCE = 'Finance';
    case VIEWER = 'Viewer';
}