<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Services\v2\UserService;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function register()
    {
        return 'create a user';
    }
}
