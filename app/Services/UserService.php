<?php

namespace App\Services;

use SoapServer;
use App\Models\V1\User;
use App\Repositories\V1\UserRepository;

class UserService
{
	const SUBSCRIPTION_SUCCESSFUL = "Subscription successful. Ensure to copy and store the generated token.";
	const UPDATE_PROFILE_SUCCESSFUL = "Profile updated successful. Ensure to copy and store the generated token.";
	
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
			$hash = $this->generateHash($email);
			return $this->genEmailTokenResponse($user, $hash, self::SUBSCRIPTION_SUCCESSFUL);
		}
	}

	public function UpdateProfile (string $oldEmail, string $newEmail, string $token) {
		if ( $user = $this->repo->findUserByEmail($oldEmail) ) {
			if ( $this->tokenIsValid($user, $token) ) {
				$user = $this->repo->updateUser($user, $newEmail);
				return $this->genEmailTokenResponse($user, $hash, self::UPDATE_PROFILE_SUCCESSFUL);
			} else {
				// token is not valid
			}
		} else {
			// user is not found
		}
	}

    public function tokenIsValid (User $user, string $token) : bool {
        return $this->generateHash($user->email) == $token;
    }

    public function genEmailTokenResponse (User $user, string $hash, string $message) {
		return [
			"email" => $user->email,
			"token" => $hash,
			"message" => $message
		];
    }

	private function generateHash ($data) {
		return hash('sha256', $data . env("SECRET_KEY"));
	}
}