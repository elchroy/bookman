<?php

namespace App\Http\Controllers\API\V1;

use \SoapServer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SoapController extends Controller
{   
	public function handle (Request $request, SoapServer $server, string $serviceName) {
		// dd($request);
		$serviceClass = "App\\Services\\$serviceName";
		$server->setClass($serviceClass);
		$server->handle();
	}
}