<?php

namespace IakID\IakApiPHP\Helpers\Validations;

class IAKValidator
{
    public static function validateCredentialRequest($request)
    {
        IAKValidationHelper::validateContentType($request);
        IAKValidationHelper::validateContentFields($request, ['apiKey', 'userHp', 'stage']);
    }
}