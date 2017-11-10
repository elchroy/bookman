<?php

namespace Tests\Unit\Services;

use Mockery as M;
use \App\Models\V1\User;
use App\Services\BookService;
use App\Services\UserService;
use App\Repositories\V1\BookRepository;
use App\Repositories\V1\UserRepository;
use TestCase;

class BookServiceTest extends TestCase {

	private $service;

	public function setUp () {
		parent::setUp();

		$this->mockServer = M::mock(\SoapServer::class);

		$this->userRepo = new UserRepository();
		$this->bookRepo = new BookRepository();

		$this->mockServer
			->shouldReceive('setClass');
		$this->service = new BookService($this->mockServer, $this->userRepo, $this->bookRepo);
		$this->user = User::find(1);
	}

	public function testServiceCanAddBook () {
		$title = "New Book";
		$response = $this->service->AddBook($title, $this->user->token);

		$this->assertEquals($title, $response["book"]['title']);
		$this->assertEquals("A new book was created successful.", $response["message"]);
	}

	public function testServiceCanGetBookById () {
		$title = "Lengend of the Seeder";
		
		$response = $this->service->GetBook(1, $this->user->token);

		$this->assertEquals($title, $response["book"]['title']);
		$this->assertEquals("Book found", $response["message"]);
	}

	public function testServiceCanGetBooksBelongingToAUser () {
		$response = $this->service->GetBooks($this->user->token);
		$books = $response['books'];

		$this->assertEquals(51, count($books));
		$this->assertEquals("Books found", $response["message"]);
	}

	public function testServiceCanUpdateBookBelongingToAUser () {
		$title = "New Lengend of the Seeder";
		$response = $this->service->UpdateBook(1, $title, $this->user->token);

		$this->assertEquals($title, $response["book"]['title']);
		$this->assertEquals("Book updated successfully", $response["message"]);
	}

	public function testServiceCanAllowAUserToDeleteHisBook () {
		$response = $this->service->DeleteBook(1, $this->user->token);

		$books = $this->user->books;
		
		$this->assertEquals(50, count($books));
		$this->assertEquals("Book deleted successfully", $response["message"]);
	}
}