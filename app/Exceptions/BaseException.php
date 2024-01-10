<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;

class BaseException extends Exception
{
    use ApiResponse;
}
