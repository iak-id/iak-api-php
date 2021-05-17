<?php

namespace IakID\IakApiPHP\Helpers\Validations;

use IakID\IakApiPHP\Exceptions\MissingArguements;

class IAKPrepaidValidator
{
    public static function validatePricelistRequest($request)
    {
        IAKValidationHelper::validateContentType($request);

        if (!empty($request['operator']) && empty($request['type'])) {
            throw new MissingArguements('Operator field is available but type field is missing.');
        }
    }

    public static function validateTopUpRequest($request)
    {
        IAKValidationHelper::validateContentType($request);
        IAKValidationHelper::validateContentFields($request, ['customerId', 'refId', 'productCode']);
    }
}