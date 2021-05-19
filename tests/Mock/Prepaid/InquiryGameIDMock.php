<?php

namespace Tests\Mock\Prepaid;

class InquiryGameIDMock
{
    public static function getGameIDMock()
    {
        return [
            'data' => [
                'username' => 'budi',
                'status' => 1,
                'message' => 'SUCCESS',
                'rc' => '00'
            ]
        ];
    }
}