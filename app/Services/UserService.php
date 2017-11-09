<?php

namespace App\Services;

use SoapServer;
use App\Repositories\V1\UserRepository;

class UserService
{
	protected $repo;
	protected $server;

	public function __construct (SoapServer $server, UserRepository $repo) {
		$this->repo = $repo;
		$this->server = $server;
		$this->server->setClass(self::class, $this->server, $this->repo);
	}

	public function handle () {
		$this->server->handle();
	}

	public function Subscribe (string $email) {
		if ($user = $this->repo->createUser($email)) {
			$hash = hash('sha256', $email . env("SECRET_KEY"));
			return [
				"email" => $email,
				"token" => $hash,
				"message" => "Subscription successful. Ensure to copy and store the generated token."
			];
		}
	}
}