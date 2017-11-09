<?php

namespace App\Services;

use SoapServer;
use App\Services\MainService;
use App\Models\V1\User;
use App\Models\V1\Book;
use App\Repositories\V1\BookRepository;

class BookService extends MainService {
	const BOOD_ADDED_SUCCESSFULLY = "A new book was created successful.";

	protected $repo;
	protected $server;

	public function __construct (SoapServer $server, BookRepository $repo) {
		$this->repo = $repo;
		$this->server = $server;
		$this->server->setClass(self::class, $this->server, $this->repo);
	}

	public function handle () {
		$this->server->handle();
	}

	public function AddBook (string $title, string $token) {
		dd(func_get_args());
	}
}