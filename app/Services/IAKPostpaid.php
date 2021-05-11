<?php

namespace IakID\IakApiPHP\Services;

use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\IAK;

class IAKPostpaid extends IAK
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->url = Url::URL_POSTPAID[$this->stage];
    }
}