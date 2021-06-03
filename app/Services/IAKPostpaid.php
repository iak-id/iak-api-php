<?php

namespace IakID\IakApiPHP\Services;

use Exception;
use IakID\IakApiPHP\Helpers\CoreHelper;
use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\Helpers\Request\Guzzle;
use IakID\IakApiPHP\Helpers\Request\RequestFormatter;
use IakID\IakApiPHP\Helpers\Validations\IAKPostpaidValidator;
use IakID\IakApiPHP\IAK;

class IAKPostpaid extends IAK
{
    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->url = Url::URL_POSTPAID[$this->stage];
    }

    public function checkStatus($request = [])
    {
        IAKPostpaidValidator::validateCheckStatusRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'commands' => 'checkstatus',
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign('cs')
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
        } catch (Exception $e) {
            Guzzle::throwIAKException($e);
        }
    }

    public function downloadBill($request = [])
    {
        IAKPostpaidValidator::validateDownloadBillRequest($request);

        $downloadBillUrl = $this->url . '/api/v1/download/' . $request['trId'] . '/1';

        try {
            return Guzzle::sendRequest($downloadBillUrl, 'GET', $this->headers);
        } catch (Exception $e) {
            Guzzle::throwIAKException($e);
        }
    }

    public function inquiry($request = [])
    {
        $requiredFields = ['code', 'hp', 'refId'];

        if (!empty($request['code']) && CoreHelper::isStringContainsString($request['code'], 'bpjs')) {
            array_push($requiredFields, 'month');
        }

        IAKPostpaidValidator::validateInquiryRequest($request, $requiredFields);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'commands' => 'inq-pasca',
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign($request['ref_id'])
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
        } catch (Exception $e) {
            Guzzle::throwIAKException($e);
        }
    }

    public function payment($request = [])
    {
        IAKPostpaidValidator::validatePaymentRequest($request);

        $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

        $request = array_merge($request, [
            'commands' => 'pay-pasca',
            'username' => $this->credential['userHp'],
            'sign' => $this->generateSign(strval($request['tr_id']))
        ]);

        try {
            return Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
        } catch (Exception $e) {
            Guzzle::throwIAKException($e);
        }
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
        } catch (Exception $e) {
            Guzzle::throwIAKException($e);
        }
    }
}