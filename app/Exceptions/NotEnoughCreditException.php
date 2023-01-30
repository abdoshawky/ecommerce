<?php

namespace App\Exceptions;

class NotEnoughCreditException extends APIException
{
    protected $message = "Not enough credit";
}
