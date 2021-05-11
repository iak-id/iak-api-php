<?php

namespace IakID\IakApiPHP\Services;

use GuzzleHttp\Exception\RequestException;
use IakID\IakApiPHP\Exceptions\IAKException;
use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\Helpers\Request\Guzzle;
use IakID\IakApiPHP\IAK;

class IAKPrepaid extends IAK
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->url = Url::URL_PREPAID[$this->stage];
    }

    public function checkBalance()
    {       
        $request = [
            'username' => $this->credential['userHp'],
            'sign' => md5($this->credential['userHp'] . $this->credential['apiKey'] . 'bl')
        ];

        try {
            return Guzzle::sendRequest($this->url . '/api/check-balance', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }
}