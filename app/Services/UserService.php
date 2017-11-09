<?php

namespace App\Services;

use SoapServer;
use App\Models\V1\User;
use App\Services\MainService;
use App\Repositories\V1\UserRepository;

class UserService extends MainService {
	const SUBSCRIPTION_SUCCESSFUL = "Subscription successful. Ensure to copy and store the generated token.";
	const UPDATE_PROFILE_SUCCESSFUL = "Profile updated successful. Ensure to copy and store the generated token.";

	protected $server;

	public function __construct (SoapServer $server, UserRepository $userRepo) {
		parent::__construct($userRepo);
		$this->server = $server;
		$this->server->setClass(self::class, $this->server, $this->userRepo);
	}

	public function handle () {
		$this->server->handle();
	}

	public function Subscribe (string $email) {
		$token = $this->generateHash($email);
		if ($user = $this->userRepo->createUser($email, $token)) {
			return $this->genEmailTokenResponse($user, $token, self::SUBSCRIPTION_SUCCESSFUL);
		}
	}

	public function UpdateProfile (string $oldEmail, string $newEmail, string $token) {
		if ( $user = $this->userRepo->findUserByEmail($oldEmail) ) {
			if ( $this->tokenIsValid($user, $token) ) {
				$user = $this->userRepo->updateUser($user, $newEmail);
				return $this->genEmailTokenResponse($user, $token, self::UPDATE_PROFILE_SUCCESSFUL);
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

    public function genEmailTokenResponse (User $user, string $token, string $message) {
		return [
			"email" => $user->email,
			"token" => $token,
			"message" => $message
		];
    }
}