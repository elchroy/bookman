<?php

namespace Tests\Unit\Repositories;

use App\Models\V1\Book;
use App\Models\V1\User;
use App\Repositories\V1\BookRepository;
use TestCase;

class BookRepositoryTest extends TestCase
{
    private $repo;

    public function setUp()
    {
        parent::setUp();
        $this->user = User::find(1);
    }

    public function testRepositoryCanCreateANewBook()
    {
        $bookTitle = 'This is the title of a new test Book.';
        $book = BookRepository::createBook($this->user, $bookTitle);

        $this->assertEquals($bookTitle, $book->title);
        $this->assertEquals(52, Book::count());
    }

    public function testRepositoryCanFindABookById()
    {
        $book = BookRepository::findById($this->user, 1);

        $this->assertEquals('Lengend of the Seeder', $book->title);
        $this->assertEquals($book->user->id, $this->user->id);
        $this->assertEquals(51, Book::count());
    }

    public function testRepositoryCanFindAllBookBelongingToUser()
    {
        $books = BookRepository::findAll($this->user);

        $this->assertEquals(51, count($books));
    }

    public function testRepositoryCanUpdateABookById()
    {
        $book = BookRepository::findById($this->user, 1);
        $book = BookRepository::updateBook($book, 'This is the new Lengend of the Seeder');

        $this->assertEquals('This is the new Lengend of the Seeder', $book->title);
    }

    public function testRepositoryCanSortBooksBasedOnBookTitle()
    {
        $lastBook = BookRepository::createBook($this->user, "AAAAAAAAAAA last Book that starts from the first letter of the alphabet.");
        $books = BookRepository::findAll($this->user, true);
        $firstBook = $books[0];

        $this->assertEquals($firstBook['title'], $lastBook['title']);
    }
}
