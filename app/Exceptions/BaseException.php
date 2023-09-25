<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponse;

class BaseException extends Exception
{

    use ApiResponse;


}

