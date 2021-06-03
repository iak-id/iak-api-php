<?php

namespace Tests\Feature\Postpaid;

use IakID\IakApiPHP\Exceptions\MissingArguements;
use Tests\Mock\Postpaid\CheckStatusMock;
use Tests\TestCase;

class CheckStatusTest extends TestCase
{
    protected $mock, $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpMock();
        $this->request = [
            'refId' => 'refid123'
        ];
    }

    /** @test */
    public function check_status_return_success_and_not_empty(): void
    {
        $response = $this->iakPostpaid->checkStatus($this->request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(CheckStatusMock::getSuccessStatusMock(), $response);
    }

    /** @test */
    public function check_status_without_ref_id_return_missing_arguements(): void
    {
        unset($this->request['refId']);

        try {
            $this->iakPostpaid->checkStatus($this->request);
            $this->assertTrue(false);
        } catch (MissingArguements $e) {
            $this->assertTrue(true);
        }
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(CheckStatusMock::getSuccessStatusMock());
    }
}