<?php

namespace App\Services;

use App\Repositories\V1\UserRepository;
use App\Repositories\V1\BookRepository;

class MainService {
	
	public function generateHash ($data) {
		return hash('sha256', $data . env("SECRET_KEY"));
	}
}