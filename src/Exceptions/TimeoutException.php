<?php

namespace SimpleRequest\Exceptions;

use Exception;

class TimeoutException extends Exception
{
    public function __construct($message)
    {
        parent::__construct("CURL Error Timeout: $message", CURLE_OPERATION_TIMEOUTED);
    }
}