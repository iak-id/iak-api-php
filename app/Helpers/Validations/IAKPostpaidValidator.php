<?php

namespace IakID\IakApiPHP\Helpers\Validations;

class IAKPostpaidValidator
{
    public static function validateCheckStatusRequest($request)
    {
        IAKValidationHelper::validateContentType($request);
        IAKValidationHelper::validateContentFields($request, ['refId']);
    }

    public static function validatePricelistRequest($request)
    {
        IAKValidationHelper::validateContentType($request);
    }
}