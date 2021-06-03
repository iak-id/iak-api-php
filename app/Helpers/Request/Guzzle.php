<?php

namespace IakID\IakApiPHP\Helpers\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use IakID\IakApiPHP\Exceptions\IAKException;
use IakID\IakApiPHP\Exceptions\UndefinedError;

class Guzzle
{
    public static function sendRequest($url, $method, $headers = [], $body = [], $connectTimeout = 10, $timeout = 30)
    {
        $client = new Client(['verify' => false]);

        $response = $client->request($method, $url, [
            'headers' => $headers,
            'json' => $body,
            'connect_timeout' => $connectTimeout,
            'timeout' => $timeout
        ])->getBody()->getContents();

        return json_decode($response, true) ? json_decode($response, true) : $response;
    }

    public static function throwIAKException($exception)
    {
        if ($exception instanceof ConnectException || $exception instanceof RequestException) {
            throw new IAKException($exception->getMessage());
        } else {
            throw new UndefinedError();
        }
    }
}