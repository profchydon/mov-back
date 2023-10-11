<?php

namespace App\Exceptions\Company;

use Exception;
use Illuminate\Http\Response;

class InvalidCompanyIDException extends Exception
{
    protected $code = Response::HTTP_BAD_REQUEST;
}
