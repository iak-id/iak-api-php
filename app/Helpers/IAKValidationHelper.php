<?php

namespace IakID\IakApiPHP\Helpers;

class IAKValidationHelper
{
    public static function isContentTypeArray($content)
    {
        return is_array($content);
    }

    public static function getMissingFields($content, $fields)
    {
        return array_diff($fields, array_keys($content));
    }
}