<?php

namespace Tests\Unit\Services;

use App\Services\MainService;
use TestCase;

class MainServiceTest extends TestCase
{
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new MainService();
    }

    public function testServiceRespondsWhenUnspecifiedMethodIsCalled()
    {
        $response = $this->service->UnavailableMethod();

        $this->assertEquals(400, $response['status']);
        $this->assertEquals('UnavailableMethod : This action is not available in the service. Please view the documentation.', $response['body']['message']);
    }
}
