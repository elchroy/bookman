<?php

namespace App\Repositories\V1;

use App\Models\V1\User;
use RepositoryInterface;

class UserRepository {

	public function createUser (string $email, string $token) {
		return User::create([
			'email' => $email,
			'token' => $token
		]);
	}

	public function findUserByEmail (string $email) {
		return User::where('email', $email)->first();
	}

	public function updateUser(User $user, string $newEmail) {
		return $user->update([
			'email' => $newEmail
		]);
	}
}