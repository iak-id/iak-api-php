<?php

namespace IakID\IakApiPHP;

use IakID\IakApiPHP\Helpers\Validations\IAKValidator;

abstract class IAK
{
    protected $credential, $stage, $url, $headers;

    public function __construct(array $data = [])
    {
        IAKValidator::validateCredentialRequest($data);

        $this->setCredential($data);

        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
        $this->stage = isset($data['stage']) && strtolower($data['stage']) == 'production' ? 'prod' : 'dev';
    }

    private function setCredential($data)
    {
        $this->credential['userHp'] = $data['userHp'] ?? null;
        $this->credential['apiKey'] = $data['apiKey'] ?? null;
    }

    protected function generateSign($sign)
    {
        return md5($this->credential['userHp'] . $this->credential['apiKey'] . $sign);
    }
}