<?php

namespace Tests\Feature\Prepaid;

use IakID\IakApiPHP\Exceptions\InvalidContentType;
use IakID\IakApiPHP\Exceptions\MissingArguements;
use Tests\Mock\Prepaid\TopUpMock;
use Tests\TestCase;

class TopUpTest extends TestCase
{
    protected $mock, $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpMock();
        $this->request = [
            'customerId' => '081357922222',
            'refId' => 'refid123',
            'productCode' => 'htelkomsel10000'
        ];
    }

    /** @test */
    public function top_up_return_success_and_not_empty()
    {
        $response = $this->iakPrepaid->topUp($this->request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(TopUpMock::getTopUpMock(), $response);
    }

    /** @test */
    public function top_up_without_ref_id_return_missing_arguements()
    {
        unset($this->request['refId']);

        try {
            $this->iakPrepaid->topUp($this->request);
            $this->assertTrue(false);
        } catch (MissingArguements $e) {
            $this->assertTrue(true);
        }
    }

    /** @test */
    public function top_up_with_string_parameter_return_invalid_content_type()
    {
        try {
            $this->iakPrepaid->topUp('request');
            $this->assertTrue(false);
        } catch (InvalidContentType $e) {
            $this->assertTrue(true);
        }
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(TopUpMock::getTopUpMock());
    }
}