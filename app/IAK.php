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
        $this->stage = strtolower($this->stage) == 'production' ? 'prod' : 'dev';
    }

    private function setCredential($data)
    {
        if (empty($data['userHp'])) {
            $this->credential['userHp'] = isset($_ENV['IAK_USERHP']) ? $_ENV['IAK_USERHP'] : '';
        } else {
            $this->credential['userHp'] = $data['userHp'];
        }

        if (empty($data['apiKey'])) {
            $this->credential['apiKey'] = isset($_ENV['IAK_APIKEY']) ? $_ENV['IAK_APIKEY'] : '';
        } else {
            $this->credential['apiKey'] = $data['apiKey'];
        }

        if (empty($data['stage'])) {
            $this->stage = isset($_ENV['IAK_STAGE']) ? $_ENV['IAK_STAGE'] : '';
        } else {
            $this->stage = $data['stage'];
        }
    }

    protected function generateSign($sign)
    {
        return md5($this->credential['userHp'] . $this->credential['apiKey'] . $sign);
    }
}