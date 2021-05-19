<?php

namespace Tests\Feature\Prepaid;

use IakID\IakApiPHP\Exceptions\MissingArguements;
use Tests\Mock\Prepaid\InquiryPrepaidMock;
use Tests\TestCase;

class InquiryGameServerTest extends TestCase
{
    protected $mock, $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->setUpMock();
        $this->request = [
            'gameCode' => '142'
        ];
    }

    /** @test */
    public function inquiry_game_server_return_success_and_not_empty(): void
    {
        $response = $this->iakPrepaid->inquiryGameServer($this->request);

        $this->assertIsArray($response);
        $this->assertNotEmpty($response);
        $this->assertEquals(InquiryPrepaidMock::getGameServerMock(), $response);
    }

    /** @test */
    public function inquiry_game_server_without_game_code_return_missing_arguements(): void
    {
        unset($this->request['gameCode']);

        try {
            $this->iakPrepaid->inquiryGameServer($this->request);
            $this->assertTrue(false);
        } catch (MissingArguements $e) {
            $this->assertTrue(true);
        }
    }

    private function setUpMock()
    {
        $this->mock = $this->mockClass('alias:IakID\IakApiPHP\Helpers\Request\Guzzle');
        $this->mock->shouldReceive('sendRequest')->andReturn(InquiryPrepaidMock::getGameServerMock());
    }
}