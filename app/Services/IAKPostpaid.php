<?php

namespace IakID\IakApiPHP\Services;

use Exception;
use IakID\IakApiPHP\Helpers\CoreHelper;
use IakID\IakApiPHP\Helpers\Formats\ResponseFormatter;
use IakID\IakApiPHP\Helpers\Formats\Url;
use IakID\IakApiPHP\Helpers\Request\Guzzle;
use IakID\IakApiPHP\Helpers\Request\RequestFormatter;
use IakID\IakApiPHP\Helpers\Validations\IAKPostpaidValidator;
use IakID\IakApiPHP\IAK;

class IAKPostpaid
{
    private $iak, $url, $headers;

    public function __construct($credential, $stage)
    {
        $this->iak = $credential;

        $this->url = Url::URL_POSTPAID[$stage];
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    public function checkStatus($request = [])
    {
        try {
            IAKPostpaidValidator::validateCheckStatusRequest($request);

            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $request = array_merge($request, [
                'commands' => 'checkstatus',
                'username' => $this->iak["userHp"],
                'sign' => IAK::generateSign($this->iak["userHp"],  $this->iak["apiKey"], 'cs')
            ]);

            $response = Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function downloadBill($request = [])
    {
        try {
            IAKPostpaidValidator::validateDownloadBillRequest($request);

            $downloadBillUrl = $this->url . '/api/v1/download/' . $request['trId'] . '/1';

            $response = Guzzle::sendRequest($downloadBillUrl, 'GET', $this->headers);
            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function inquiry($request = [])
    {
        try {
            $requiredFields = ['code', 'hp', 'refId'];

            if (!empty($request['code']) && CoreHelper::isStringContainsString($request['code'], 'bpjs')) {
                array_push($requiredFields, 'month');
            }

            IAKPostpaidValidator::validateInquiryRequest($request, $requiredFields);

            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $request = array_merge($request, [
                'commands' => 'inq-pasca',
                'username' => $this->credential['userHp'],
                'sign' => IAK::generateSign($this->iak["userHp"],  $this->iak["apiKey"], $request['ref_id'])
            ]);

            $response = Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function payment($request = [])
    {
        try {
            IAKPostpaidValidator::validatePaymentRequest($request);

            $request = RequestFormatter::formatArrayKeysToSnakeCase($request);

            $request = array_merge($request, [
                'commands' => 'pay-pasca',
                'username' => $this->credential['userHp'],
                'sign' => IAK::generateSign($this->iak["userHp"],  $this->iak["apiKey"], strval($request['tr_id']))
            ]);

            $response = Guzzle::sendRequest($this->url . '/api/v1/bill/check', 'POST', $this->headers, $request);
            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }

    public function pricelist($request = [])
    {
        try {
            IAKPostpaidValidator::validatePricelistRequest($request);

            $request = array_merge($request, [
                'commands' => 'pricelist-pasca',
                'username' => $this->credential['userHp'],
                'sign' => IAK::generateSign($this->iak["userHp"],  $this->iak["apiKey"], 'pl')
            ]);

            $postpaidUrl = $this->url . '/api/v1/bill/check';

            if (!empty($request['type'])) {
                $postpaidUrl .= '/' . $request['type'];
            }

            $response = Guzzle::sendRequest($postpaidUrl, 'POST', $this->headers, $request);
            $response = $response['data'];

            return ResponseFormatter::formatResponse($response);
        } catch (Exception $e) {
            return Guzzle::handleException($e);
        }
    }
}
