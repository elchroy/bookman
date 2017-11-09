<?php

namespace App\Services;

class UserService
{
	protected $server;

	public function __construct (\SoapServer $server) {
		$this->server = $server;
		$this->server->setClass(self::class, $this->server);
	}

	public function handle () {
		$this->server->handle();
	}

	public function Subscribe (string $email) {
		return $email;
	}
}