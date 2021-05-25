<?php

namespace IakID\IakApiPHP\Helpers\Validations;

class IAKPostpaidValidator
{
    public static function validatePricelistRequest($request)
    {
        IAKValidationHelper::validateContentType($request);
    }
}