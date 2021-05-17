<?php

namespace Tests\Feature\Prepaid;

use IakID\IakApiPHP\Exceptions\MissingArguements;
use Tests\Mock\Prepaid\PricelistMock;
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
        $response = $this->iakPrepaid->pricelist();

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(PricelistMock::getPricelistMock(), $response);
    }

    /** @test */
    public function pricelist_with_type_return_success_and_not_empty(): void
    {
        $request = [
            'type' => 'pulsa'
        ];

        $response = $this->iakPrepaid->pricelist($request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(PricelistMock::getPricelistMock(), $response);
    }

    /** @test */
    public function pricelist_with_type_and_operator_return_success_and_not_empty(): void
    {
        $request = [
            'type' => 'pulsa',
            'operator' => 'telkomsel'
        ];

        $response = $this->iakPrepaid->pricelist($request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(PricelistMock::getPricelistMock(), $response);
    }

    /** @test */
    public function pricelist_with_operator_only_return_missing_arguements(): void
    {
        $request = [
            'operator' => 'telkomsel'
        ];

        try {
            $this->iakPrepaid->pricelist($request);
            $this->assertTrue(false);
        } catch (MissingArguements $e) {
            $this->assertTrue(true);
        }
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(PricelistMock::getPricelistMock());
    }
}