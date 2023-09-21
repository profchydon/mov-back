<?php

namespace App\Http\Controllers\v2;

use App\Domains\DTO\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\SsoServiceInterface;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param UserRepositoryInterface $userRepositoryInterface
     */
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly SsoServiceInterface $ssoService
    )
    {
    }

    public function register(CreateUserRequest $request)
    {
        $userDTO = CreateUserDTO::fromArray($request->all());

        $resp = $this->ssoService->createUser($userDTO);

        if($resp->status() != Response::HTTP_CREATED){
            return $this->error(Response::HTTP_BAD_REQUEST, $resp->json()['message']);
        }

        $user = $this->userRepository->create($userDTO);
        
        return $this->response(
            Response::HTTP_CREATED,
            'Account created successfully',
            $user,
        );
    }
}
