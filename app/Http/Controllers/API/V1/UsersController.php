<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

function test () {
	return "testing...";
}

class UsersController extends Controller
{
	public function handle (UserService $service) {
		$service->handle();
	}
}