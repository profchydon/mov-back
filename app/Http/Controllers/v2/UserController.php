<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(private readonly UserRepositoryInterface $userRepositoryInterface)
    {
        
    }
    
    public function register()
    {
        return 'create a user';
    }
}
