<?php

namespace IakID\IakApiPHP\Helpers;

use IakID\IakApiPHP\Exceptions\InvalidContentType;
use IakID\IakApiPHP\Exceptions\MissingArguements;

class IAKValidator
{
    public static function validateContentType($content)
    {
        if (!IAKValidationHelper::isContentTypeArray($content)) {
            throw new InvalidContentType();
        }
    }

    public static function validateContentFields($content, $fields)
    {
        $missingFields = IAKValidationHelper::getMissingFields($content, $fields);

        if (!empty($missingFields)) {
            throw new MissingArguements('Field ' . $missingFields[0] . ' is missing');
        }
    }

    public static function validateCredentialRequest($request)
    {
        self::validateContentType($request);
        self::validateContentFields($request, ['apiKey', 'userHp', 'stage']);
    }
}