<?php

namespace App\Repositories\V1;

use App\Models\V1\User;
use RepositoryInterface;

class UserRepository {

	public function createUser (string $email) {
		return User::create([
			'email' => $email,
		]);
	}
}