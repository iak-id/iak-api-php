<?php

namespace IakID\IakApiPHP\Helpers\Request;

use IakID\IakApiPHP\Helpers\Formats\StringFormatter;

class RequestFormatter
{
    public static function formatArrayKeysToSnakeCase($arr)
    {
        foreach ($arr as $key => $value) {
            $arr[StringFormatter::convertCamelCaseToSnakeCase($key)] = $value;
            unset($arr[$key]);
        }

        return $arr;
    }
}