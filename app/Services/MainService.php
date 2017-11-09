<?php

namespace App\Services;

use App\Repositories\V1\UserRepository;
use App\Repositories\V1\BookRepository;

class MainService {

	protected $userRepo;
	protected $bookRepo;

	public function __construct (UserRepository $userRepo, BookRepository $bookRepo = null) {
		$this->userRepo = $userRepo;
		$this->bookRepo = $bookRepo;
	}

	public function generateHash ($data) {
		return hash('sha256', $data . env("SECRET_KEY"));
	}
}