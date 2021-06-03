<?php

namespace IakID\IakApiPHP\Exceptions;

class UndefinedError extends BaseException
{
    public function setMessage()
    {
        return 'Undefined error exception';
    }
}
