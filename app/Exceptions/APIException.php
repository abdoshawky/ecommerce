<?php

namespace App\Exceptions;

use Exception;

class APIException extends Exception
{
    protected $code = 400;
}
