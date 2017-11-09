<?php

namespace App\Repositories\V1;

use App\Models\V1\Book;
use App\Models\V1\User;
use RepositoryInterface;

class BookRepository {

	public function createBook (User $user, string $title) {
		return $user->books()->create([
			'title' => $title
		]);
	}
}