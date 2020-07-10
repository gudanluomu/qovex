<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ApiRequestException extends Exception implements HttpExceptionInterface
{
    protected $exceptionContext;

    public function __construct($message = "", $exceptionContext = [], $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->exceptionContext = $exceptionContext;
    }

    public function getStatusCode()
    {
        return 400;
    }

    public function getHeaders()
    {

    }

    public function exceptionContext()
    {
        return $this->exceptionContext;
    }
}
