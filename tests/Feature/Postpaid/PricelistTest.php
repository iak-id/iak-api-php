<?php

namespace Tests\Feature\Postpaid;

use IakID\IakApiPHP\Helpers\Formats\ResponseFormatter;
use Tests\Mock\Postpaid\PricelistMock;
use Tests\TestCase;

class PricelistTest extends TestCase
{
    protected $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpMock();
    }

    /** @test */
    public function pricelist_return_success_and_not_empty(): void
    {
        $response = $this->iakPostpaid->pricelist();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(ResponseFormatter::formatResponse(
            PricelistMock::getPricelistMock()['data']
        ), $response);
    }

    /** @test */
    public function pricelist_with_status_return_success_and_not_empty(): void
    {
        $request = [
            'status' => 'all'
        ];

        $response = $this->iakPostpaid->pricelist($request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(ResponseFormatter::formatResponse(
            PricelistMock::getPricelistMock()['data']
        ), $response);
    }

    /** @test */
    public function pricelist_with_type_return_success_and_not_empty(): void
    {
        $request = [
            'type' => 'pdam'
        ];

        $response = $this->iakPostpaid->pricelist($request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(ResponseFormatter::formatResponse(
            PricelistMock::getPricelistMock()['data']
        ), $response);
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(PricelistMock::getPricelistMock());
    }
}