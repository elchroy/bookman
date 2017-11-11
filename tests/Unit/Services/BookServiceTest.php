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

        $this->assertEquals($title, $response['book']['title']);
        $this->assertEquals('A new book was created successful.', $response['message']);
    }

    public function testServiceFailsToAddBookWhenTokenIsInvalid()
    {
        $title = 'New Book';
        $response = $this->service->AddBook($title, $this->invalidToken);

        $this->assertEquals($this->invalidToken, $response['token']);
        $this->assertEquals($this->invalidTokenMessage, $response['message']);
    }

    public function testServiceCanGetBookById()
    {
        $title = 'Lengend of the Seeder';

        $response = $this->service->GetBook(1, $this->user->token);

        $this->assertEquals($title, $response['book']['title']);
        $this->assertEquals('Book found', $response['message']);
    }

    public function testServiceFailsToGetBookWhenTokenIsInvalid()
    {
        $response = $this->service->GetBook(1, $this->invalidToken);

        $this->assertEquals($this->invalidToken, $response['token']);
        $this->assertEquals($this->invalidTokenMessage, $response['message']);
    }

    public function testServiceFailsToGetBookWhenBookIsNotFound()
    {
        $response = $this->service->GetBook(1000, $this->user->token);

        $this->assertEquals('Book not found', $response['message']);
    }

    public function testServiceCanGetBooksBelongingToAUser()
    {
        $response = $this->service->GetBooks($this->user->token);
        $books = $response['books'];

        $this->assertEquals(51, count($books));
        $this->assertEquals('Books found', $response['message']);
    }

    public function testServiceFailsToGetBooksWhenTokenIsInvalid()
    {
        $response = $this->service->GetBooks($this->invalidToken);

        $this->assertEquals($this->invalidToken, $response['token']);
        $this->assertEquals($this->invalidTokenMessage, $response['message']);
    }

    public function testServiceRespondsWhenThereAreNoBookForCurrentUser()
    {
        $response = $this->service->GetBooks($this->anotherUser->token);

        $this->assertEquals('There are no books in your list.', $response['message']);
    }

    public function testServiceCanUpdateBookBelongingToAUser()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->user->token);

        $this->assertEquals($title, $response['book']['title']);
        $this->assertEquals('Book updated successfully', $response['message']);
    }

    public function testServiceDoesNotUpdateWhenBookINotFound()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->anotherUser->token);

        $this->assertEquals('Book not found', $response['message']);
    }

    public function testServiceFailsToUpdateBookWhenTokenIsInvalid()
    {
        $title = 'New Lengend of the Seeder';
        $response = $this->service->UpdateBook(1, $title, $this->invalidToken);

        $this->assertEquals($this->invalidToken, $response['token']);
        $this->assertEquals($this->invalidTokenMessage, $response['message']);
    }

    public function testServiceCanAllowAUserToDeleteHisBook()
    {
        $response = $this->service->DeleteBook(1, $this->user->token);

        $books = $this->user->books;

        $this->assertEquals(50, count($books));
        $this->assertEquals('Book deleted successfully', $response['message']);
    }

    public function testServiceDoesNotDeleteWhenBookINotFound()
    {
        $response = $this->service->DeleteBook(1, $this->anotherUser->token);

        $this->assertEquals('Book not found', $response['message']);
    }

    public function testServiceFailsToDeleteBookWhenTokenIsInvalid()
    {
        $response = $this->service->DeleteBook(1, $this->invalidToken);

        $this->assertEquals($this->invalidToken, $response['token']);
        $this->assertEquals($this->invalidTokenMessage, $response['message']);
    }
}
