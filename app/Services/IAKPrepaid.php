<?php

namespace IakID\IakApiPHP\Services;

use GuzzleHttp\Exception\RequestException;
use IakID\IakApiPHP\Exceptions\IAKException;
use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\Helpers\Request\Guzzle;
use IakID\IakApiPHP\Helpers\Request\RequestFormatter;
use IakID\IakApiPHP\Helpers\Validations\IAKPrepaidValidator;
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
            'sign' => $this->generateSign('bl')
        ];

        try {
            return Guzzle::sendRequest($this->url . '/api/check-balance', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }

    public function checkStatus($request = [])
    {
        IAKPrepaidValidator::validateCheckStatusRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign($request['ref_id'])
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/check-status', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }

    public function inquiryGameID($request = [])
    {
        IAKPrepaidValidator::validateInquiryGameIDRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign($request['game_code'])
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/inquiry-game', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }

    public function inquiryGameServer($request = [])
    {
        IAKPrepaidValidator::validateInquiryGameServerRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign($request['game_code'])
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/inquiry-game-server', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }

    public function pricelist($request = [])
    {
        IAKPrepaidValidator::validatePricelistRequest($request);

        $request = array_merge($request, [
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign('pl')
        ]);

        $prepaidUrl = $this->url . '/api/pricelist';

        if (!empty($request['type'])) {
            $prepaidUrl .= '/' . $request['type'];
        }

        if (!empty($request['operator'])) {
            $prepaidUrl .= '/' . $request['operator'];
        }

        try {
            return Guzzle::sendRequest($prepaidUrl, 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }

    public function topUp($request = [])
    {
        IAKPrepaidValidator::validateTopUpRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign($request['ref_id'])
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/top-up', 'POST', $this->headers, $request);
        } catch (RequestException $e) {
            throw new IAKException($e->getMessage());
        }
    }
}