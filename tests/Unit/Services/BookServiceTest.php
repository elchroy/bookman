<?php

namespace Tests\Unit\Services;

use App\Models\V1\User;
use App\Services\BookService;
use TestCase;

class BookServiceTest extends TestCase
{
    private $service;

    public function setUp()
    {
        parent::setUp();

        $this->invalidTokenMessage = 'Invalid Token. Please enter your subscription token.';
        $this->invalidToken = 'INVALID_TOKEN';
        $this->service = new BookService();
        $this->user = User::find(1);
        $this->anotherUser = User::create([
            'email' => 'current-user@email.com',
            'token' => '__CURRENT_USER_TOKEN__',
        ]);
    }

    public function testServiceCanAddBook()
    {
        $title = 'New Book';
        $response = $this->service->AddBook($title, $this->user->token);

        $this->assertEquals(201, $response['status']);

        $body = $response['body'];

        $this->assertEquals($title, $body['book']['title']);
        $this->assertEquals('A new book was created successful.', $body['message']);
    }

    public function testServiceFailsToAddBookWhenTokenIsInvalid()
    {
        $title = 'New Book';
        $response = $this->service->AddBook($title, $this->invalidToken);

        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($this->invalidToken, $body['token']);
        $this->assertEquals($this->invalidTokenMessage, $body['message']);
    }

    public function testServiceCanGetBookById()
    {
        $title = 'Lengend of the Seeder';

        $response = $this->service->GetBook(1, $this->user->token);

        $this->assertEquals(200, $response['status']);

        $body = $response['body'];

        $this->assertEquals($title, $body['book']['title']);
        $this->assertEquals('Book found', $body['message']);
    }

    public function testServiceFailsToGetBookWhenTokenIsInvalid()
    {
        $response = $this->service->GetBook(1, $this->invalidToken);

        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($this->invalidToken, $body['token']);
        $this->assertEquals($this->invalidTokenMessage, $body['message']);
    }

    public function testServiceFailsToGetBookWhenBookIsNotFound()
    {
        $response = $this->service->GetBook(1000, $this->user->token);

        $this->assertEquals(404, $response['status']);

        $body = $response['body'];

        $this->assertEquals('Book not found', $body['message']);
    }

    public function testServiceCanGetBooksBelongingToAUser()
    {
        $response = $this->service->GetBooks($this->user->token);

        $this->assertEquals(200, $response['status']);

        $body = $response['body'];
        $books = $body['books'];

        $this->assertEquals(51, count($books));
        $this->assertEquals('Books found', $body['message']);
    }

    public function testServiceFailsToGetBooksWhenTokenIsInvalid()
    {
        $response = $this->service->GetBooks($this->invalidToken);

        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($this->invalidToken, $body['token']);
        $this->assertEquals($this->invalidTokenMessage, $body['message']);
    }

    public function testServiceRespondsWhenThereAreNoBookForCurrentUser()
    {
        $response = $this->service->GetBooks($this->anotherUser->token);

        $this->assertEquals(404, $response['status']);

        $body = $response['body'];

        $this->assertEquals('There are no books in your list.', $body['message']);
    }

    public function testServiceCanUpdateBookBelongingToAUser()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->user->token);

        $this->assertEquals(200, $response['status']);

        $body = $response['body'];

        $this->assertEquals($title, $body['book']['title']);
        $this->assertEquals('Book updated successfully', $body['message']);
    }

    public function testServiceDoesNotUpdateWhenBookINotFound()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->anotherUser->token);

        $this->assertEquals(404, $response['status']);

        $body = $response['body'];

        $this->assertEquals('Book not found', $body['message']);
    }

    public function testServiceFailsToUpdateBookWhenTokenIsInvalid()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->invalidToken);

        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($this->invalidToken, $body['token']);
        $this->assertEquals($this->invalidTokenMessage, $body['message']);
    }

    public function testServiceCanAllowAUserToDeleteHisBook()
    {
        $response = $this->service->DeleteBook(1, $this->user->token);

        $this->assertEquals(204, $response['status']);

        $body = $response['body'];

        $books = $this->user->books;

        $this->assertEquals(50, count($books));
        $this->assertEquals('Book deleted successfully', $body['message']);
    }

    public function testServiceDoesNotDeleteWhenBookINotFound()
    {
        $response = $this->service->DeleteBook(1, $this->anotherUser->token);

        $this->assertEquals(404, $response['status']);

        $body = $response['body'];

        $this->assertEquals('Book not found', $body['message']);
    }

    public function testServiceFailsToDeleteBookWhenTokenIsInvalid()
    {
        $response = $this->service->DeleteBook(1, $this->invalidToken);

        $this->assertEquals(400, $response['status']);

        $body = $response['body'];

        $this->assertEquals($this->invalidToken, $body['token']);
        $this->assertEquals($this->invalidTokenMessage, $body['message']);
    }
}
