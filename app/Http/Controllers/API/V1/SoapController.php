<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use SoapServer;

class SoapController extends Controller
{
    public function handle(SoapServer $server, string $serviceName)
    {
        $serviceClass = "App\\Services\\$serviceName";
        $server->setClass($serviceClass);
        $server->handle();
    }
}
