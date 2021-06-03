<?php

namespace IakID\IakApiPHP\Helpers\Formats;

class Url
{
    public const URL_PREPAID = [
        'SANDBOX' => 'https://prepaid.iak.dev',
        'PRODUCTION' => 'https://prepaid.iak.id'
    ];

    public const URL_POSTPAID = [
        'SANDBOX' => 'https://testpostpaid.mobilepulsa.net',
        'PRODUCTION' => 'https://mobilepulsa.net'
    ];
}