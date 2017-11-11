<?php

namespace App\Services;

use App\Repositories\V1\UserRepository;
use App\Repositories\V1\BookRepository;

class MainService {

	/**
	 * Token provided is invalie, does not match email.
	 */
	const INVALID_TOKEN = "Invalid Token. Please enter your subscription token.";
	
	/**
	 * Generate hash using env key
	 * @param  [type] $data to be hashed
	 * @return [string] The generated hash
	 */
	public function generateHash ($data) : string {
		return hash('sha256', $data . env("SECRET_KEY"));
	}

    /**
     * Response for Invalid token
     * @param  string $token Invalid token
     * @return [array
     */
    public function getInvalidTokenResponse (string $token) : array {
    	return [
    		'token' => $token,
    		'message' => self::INVALID_TOKEN
    	];
    }
}