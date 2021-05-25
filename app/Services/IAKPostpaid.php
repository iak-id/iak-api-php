<?php

namespace IakID\IakApiPHP\Services;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use IakID\IakApiPHP\Exceptions\IAKException;
use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\Helpers\Request\Guzzle;
use IakID\IakApiPHP\Helpers\Validations\IAKPostpaidValidator;
use IakID\IakApiPHP\IAK;

class IAKPostpaid extends IAK
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->url = Url::URL_POSTPAID[$this->stage];
    }

    public function pricelist($request = [])
    {
        IAKPostpaidValidator::validatePricelistRequest($request);

        $request = array_merge($request, [
            'commands' => 'pricelist-pasca',
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign('pl')
        ]);

        $postpaidUrl = $this->url . '/api/v1/bill/check';

        if (!empty($request['type'])) {
            $postpaidUrl .= '/' . $request['type'];
        }

        try {
            return Guzzle::sendRequest($postpaidUrl, 'POST', $this->headers, $request);
        } catch (ConnectException $e) {
            throw new IAKException($e->getMessage());
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }
}