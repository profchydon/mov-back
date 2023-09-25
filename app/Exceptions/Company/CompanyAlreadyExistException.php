<?php

namespace App\Exceptions\Company;

use App\Exceptions\BaseException;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class CompanyAlreadyExistException extends BaseException
{

    public function message(): JsonResponse
    {

        return $this->error(Response::HTTP_CONFLICT, __('messages.email-exist'));

    }

}

