<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserAlreadyExistException extends BaseException
{
    public function message(): JsonResponse
    {
        return $this->error(Response::HTTP_CONFLICT, __('messages.email-exist'));
    }
}
