<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
	public function handle (BookService $service) {
		$service->handle();
	}
}