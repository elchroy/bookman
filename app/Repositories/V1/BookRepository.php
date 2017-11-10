<?php

namespace App\Repositories\V1;

use App\Models\V1\Book;
use App\Models\V1\User;

class BookRepository {

	public function createBook (User $user, string $title) {
		return $user->books()->create([
			'title' => $title
		]);
	}

	public function findById (User $user, string $id) {
		return $user->books()->find($id);
	}

	public function findAll (User $user) {
		return $user->books->map(function (Book $book) {
			return [
				"id" => $book->id,
				"title" => $book->title
			];
		})->toArray();
	}

	public function updateBook (Book $book, string $newTitle) {
		$book->update([
			'title' => $newTitle
		]);
		return $book;
	}
}