<?php

namespace Tests\Feature\Postpaid;

use IakID\IakApiPHP\Exceptions\MissingArguements;
use Tests\Mock\Postpaid\PaymentPostpaidMock;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    protected $mock, $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpMock();
        $this->request = [
            'trId' => 1
        ];
    }

    /** @test */
    public function payment_return_success_and_not_empty(): void
    {
        $response = $this->iakPostpaid->payment($this->request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(PaymentPostpaidMock::getSuccessMock(), $response);
    }

    /** @test */
    public function payment_without_tr_id_return_missing_arguements(): void
    {
        unset($this->request['trId']);

        try {
            $this->iakPostpaid->payment($this->request);
            $this->assertTrue(false);
        } catch (MissingArguements $e) {
            $this->assertTrue(true);
        }
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(PaymentPostpaidMock::getSuccessMock());
    }
}