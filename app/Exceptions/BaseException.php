<?php

namespace IakID\IakApiPHP\Exceptions;

use Exception;

abstract class BaseException extends Exception
{
    public function __construct($message = null)
    {
        $this->message = $message ?? $this->setMessage();
        $this->setStatusCode();
    }

    abstract public function setMessage();
}