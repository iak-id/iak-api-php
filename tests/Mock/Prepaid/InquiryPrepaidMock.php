<?php

namespace Tests\Mock\Prepaid;

class InquiryPrepaidMock
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

    public static function getGameServerMock()
    {
        return [
            'data' => [
                'servers' => [
                    [
                        'name' => 'Test 1',
                        'value' => '90001'
                    ],
                    [
                        'name' => 'Test 2',
                        'value' => '90002'
                    ]
                ],
                'status' => 1,
                'message' => 'SUCCESS',
                'rc' => '00'
            ]
        ];
    }
}