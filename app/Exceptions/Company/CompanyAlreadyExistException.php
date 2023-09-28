<?php

namespace App\Exceptions\Company;

use App\Exceptions\BaseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyAlreadyExistException extends BaseException
{
    public function message(): JsonResponse
    {
        return $this->error(Response::HTTP_CONFLICT, __('messages.email-exist'));
    }
}
