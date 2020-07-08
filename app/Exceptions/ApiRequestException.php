<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ApiRequestException extends Exception
{
    protected $exceptionContext;

    public function __construct($message = "", $exceptionContext = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->exceptionContext = $exceptionContext;
    }

    public function exceptionContext()
    {
        return $this->exceptionContext;
    }
}
