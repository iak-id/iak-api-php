<?php

namespace IakID\IakApiPHP\Helpers\Request;

use GuzzleHttp\Client;

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
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}