<?php
namespace App\Services\v2;

use App\Repositories\UserRepositoryInterface;

class UserService
{
    private UserRepositoryInterface $userRepositoryInterface;
    
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface) {
        $this->userRepositoryInterface = $userRepositoryInterface;
    }
}