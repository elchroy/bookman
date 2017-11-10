<?php

namespace Tests\Unit\Repositories;

use \App\Models\V1\Book;
use \App\Models\V1\User;
use App\Repositories\V1\BookRepository;
use TestCase;

class BookRepositoryTest extends TestCase {

	private $repo;

	public function setUp () {
		parent::setUp();
		$this->repo = new BookRepository();
		$this->user = User::find(1);
	}

	public function testRepositoryCanCreateANewBook () {
		$bookTitle = "This is the title of a new test Book.";
		$book = $this->repo->createBook($this->user, $bookTitle);

		$this->assertEquals($bookTitle, $book->title);
		$this->assertEquals(52, Book::count());
	}

	public function testRepositoryCanFindABookById () {
		$book = $this->repo->findById($this->user, 1);

		$this->assertEquals("Lengend of the Seeder", $book->title);
		$this->assertEquals(51, Book::count());
	}

	public function testRepositoryCanFindAllBookBelongingToUser () {
		$books = $this->repo->findAll($this->user);

		$this->assertEquals(51, count($books));
	}

	public function testRepositoryCanUpdateABookById () {
		$book = $this->repo->findById($this->user, 1);
		$book = $this->repo->updateBook($book, "This is the new Lengend of the Seeder");

		$this->assertEquals("This is the new Lengend of the Seeder", $book->title);
	}
}