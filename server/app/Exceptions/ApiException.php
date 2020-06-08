<?php

namespace App\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpException
{
    /**
     * @param $statusCode
     * @param null $message
     */
    public function __construct($statusCode, $message = null)
    {
        parent::__construct($statusCode, $message, null, [], null);
    }
}