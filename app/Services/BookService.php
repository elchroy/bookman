<?php

namespace App\Services;

use SoapServer;
use App\Services\MainService;
use App\Models\V1\User;
use App\Models\V1\Book;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\BookRepository;

class BookService extends MainService {
	const BOOK_ADDED_SUCCESSFULLY = "A new book was created successful.";
	const BOOK_FOUND = "Book found";
	const BOOK_UPDATED_SUCCESSFULLY = "Book updated successfully";
	const BOOK_DELETED = "Book deleted successfully";
	const BOOKS_FOUND = "Books found";

	

	public function __construct (SoapServer $server, UserRepository $userRepo, BookRepository $bookRepo) {
		parent::__construct($userRepo, $bookRepo);
		$this->server = $server;
		$this->server->setClass(self::class, $this->server, $this->userRepo, $this->bookRepo);
	}

	public function handle () {
		$this->server->handle();
	}

	public function AddBook (string $title, string $token) {
		if ($user = $this->userRepo->findUserByToken($token)) {
			if ($book = $this->bookRepo->createBook($user, $title)) {
				return $this->getBookResponse($book, self::BOOK_ADDED_SUCCESSFULLY);
			}
		}
	}

	public function GetBook (int $id, string $token) {
		if ($user = $this->userRepo->findUserByToken($token)) {
			if ($book = $this->bookRepo->findById($user, $id)) {
				return $this->getBookResponse($book, self::BOOK_FOUND);
			}
		}
	}

	public function GetBooks (string $token) {
		if ($user = $this->userRepo->findUserByToken($token)) {
			if ($books = $this->bookRepo->findAll($user)) {
				return $this->getBooksResponse($books, self::BOOKS_FOUND);
			}
		}
	}

	public function UpdateBook (int $id, string $newTitle, string $token) {
		if ($user = $this->userRepo->findUserByToken($token)) {
			if ($book = $this->bookRepo->findById($user, $id)) {
				$book = $this->bookRepo->updateBook($book, $newTitle);
				return $this->getBookResponse($book, self::BOOK_UPDATED_SUCCESSFULLY);
			}
		}
	}

	public function DeleteBook (int $id, string $token) {
		if ($user = $this->userRepo->findUserByToken($token)) {
			if ($book = $this->bookRepo->findById($user, $id)) {
				$book->delete();
				return $this->getDeleteResponse(self::BOOK_DELETED);
			}
		}
	}

	public function getDeleteResponse (string $message) {
		return [
			"message" => $message
		];
	}

	private function getBookResponse (Book $book, string $message) {
		return [
			"book" => [
				"id" => $book->id,
				"title" => $book->title,
			],
			"message" => $message
		];
	}

	private function getBooksResponse (array $books, string $message) {
		return [
			'books' => $books,
			'message' => $message
		];
	}
}