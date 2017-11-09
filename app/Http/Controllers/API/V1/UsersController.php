<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
	public function handle (UserService $service) {
		$service->handle();
	}
}