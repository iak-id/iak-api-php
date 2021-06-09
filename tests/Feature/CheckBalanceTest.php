<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Mock\CheckBalanceMock;

class CheckBalanceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /** @test */
    public function check_balance_return_success_and_not_empty()
    {
        $mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $mock->shouldReceive('sendRequest')->andReturn(CheckBalanceMock::getCheckBalanceSuccessResult());

        $response = $this->iakPrepaid->checkBalance();

        $this->assertTrue(is_array($response));
        $this->assertNotEmpty($response);
        $this->assertEquals(CheckBalanceMock::getCheckBalanceSuccessResult(), $response);
    }
}