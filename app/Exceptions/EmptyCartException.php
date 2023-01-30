<?php

namespace App\Exceptions;

class EmptyCartException extends APIException
{
    protected $message = "Cart is empty";
}
