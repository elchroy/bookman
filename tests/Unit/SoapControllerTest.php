<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\SoapController;
use App\Services\MainService;
use Mockery as M;
use SoapServer;
use TestCase;

class SoapControllerTest extends TestCase
{
    private $mockServer;

    public function setUp()
    {
        parent::setUp();
        $this->mockServer = M::mock(SoapServer::class);
    }

    public function testControllerCanHandleSoapRequest()
    {
        $serviceName = 'MainService';

        $this->mockServer
            ->shouldReceive('setClass')
            ->with(MainService::class)
            ->shouldReceive('handle');

        $controller = new SoapController();
        $controller->handle($this->mockServer, $serviceName);
    }
}
