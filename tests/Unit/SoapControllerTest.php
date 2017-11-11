<?php

namespace Tests\Unit;

use Mockery as M;
use SoapServer;
use TestCase;
use App\Services\MainService;
use App\Http\Controllers\API\V1\SoapController;


class SoapControllerTest extends TestCase
{
	public function testControllerCanHandleSoapRequest () {
		$mockServer = M::mock(SoapServer::class);
		$serviceName = "MainService";
		
		$mockServer
			->shouldReceive('setClass')
			->with(MainService::class)
			->shouldReceive('handle');

		$controller = new SoapController();
		$controller->handle($mockServer, $serviceName);
	}
}