<?php

namespace App\Services;

class MainService {

	public function generateHash ($data) {
		return hash('sha256', $data . env("SECRET_KEY"));
	}
}