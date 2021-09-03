<?php

namespace Tests;

use IakID\IakApiPHP\IAK;
use IakID\IakApiPHP\Services\IAKPostpaid;
use IakID\IakApiPHP\Services\IAKPrepaid;
use PHPUnit\Framework\TestCase as BaseTest;

use Mockery;

class TestCase extends BaseTest
{
    protected $data, $iakPrepaid, $iakPostpaid;

    public function setUp(): void
    {
        $this->data = [
            'userHp' => 'user_testing',
            'apiKey' => 'api_key',
            'stage' => 'sandbox'
        ];

        $iak = new IAK($this->data);

        $this->iakPrepaid = $iak->PrePaid();
        $this->iakPostpaid = $iak->PostPaid();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }

    public function mockClass($class)
    {
        return Mockery::mock($class);
    }
}
