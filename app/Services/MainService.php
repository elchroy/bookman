<?php

namespace App\Services;

use App\Repositories\V1\UserRepository;
use App\Repositories\V1\BookRepository;

class MainService {
	
	/**
	 * Generate hash using env key
	 * @param  [type] $data to be hashed
	 * @return [string] The generated hash
	 */
	public function generateHash ($data) : string {
		return hash('sha256', $data . env("SECRET_KEY"));
	}
}