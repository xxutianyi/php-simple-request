<?php

namespace SimpleRequest\Exceptions;

use Exception;

class ServerException extends Exception
{
    protected int $httpCode;
    protected string $httpResponse;

    public function __construct(int $httpCode, string $httpResponse)
    {
        $message = "HTTP Response Server Error";
        $this->httpCode = $httpCode;
        $this->httpResponse = $httpResponse;
        parent::__construct("$message:[$httpCode]-$httpResponse");
    }

    /**
     * @return int
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * @return string
     */
    public function getHttpResponse(): string
    {
        return $this->httpResponse;
    }
}