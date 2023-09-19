<?php

namespace App\Http\Controllers\v2;

use App\Domains\DTO\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepositoryInterface
    )
    {
    }

    public function register(CreateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $userDTO = CreateUserDTO::fromArray($data);
        $user = $this->userRepositoryInterface->create($userDTO);

        return $this->response(
            true,
            'Account created successfully',
            new UserResource($user),
        );
    }
}
