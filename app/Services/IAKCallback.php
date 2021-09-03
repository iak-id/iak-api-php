<?php

namespace IakID\IakApiPHP\Services;

use Symfony\Component\HttpFoundation\Request;

class IAKCallback
{

    public $request, $privateKey, $_ip;

    const API_NOTIFICATIONS = [
        'SANDBOX' => '52.76.169.212',
        'PRODUCTION' => '52.220.38.194'
    ];


    public function __construct($credential, $stage)
    {
        $this->iak = $credential;
        $this->_ip = self::API_NOTIFICATIONS[$stage];
        $this->request = Request::createFromGlobals();
    }


    public function get()
    {
        return $this->request->getContent();
    }

    public function signature()
    {
        $data = json_decode($this->get(), true);
        return md5($this->iak["userHp"] . $this->iak["apiKey"] . $data['data']['ref_id']);
    }



    public function validateSignature(): bool
    {
        $data = json_decode($this->get(), true);

        if ($data['data']['sign'] !== $this->signature()) {
            return false;
        }

        return true;
    }

    public function callbackIPNotifications()
    {
        return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
    }

    public function validateIPNotifications(): bool
    {
        if ($this->_ip !== $this->callbackIPNotifications()) {
            return false;
        }

        return true;
    }
}
