<?php

namespace App\Http\Controllers\v2;

use App\Domains\DTO\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(private readonly UserRepositoryInterface $userRepositoryInterface)
    {
    }

    public function register(CreateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = 

        $userDTO = CreateUserDTO::fromArray($data);

        return 'create a user';
    }
}
