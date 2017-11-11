<?php

namespace App\Services;

use App\Models\V1\Book;
use App\Models\V1\User;
use App\Repositories\V1\BookRepository;
use App\Repositories\V1\UserRepository;

/**
 * Book Service to handle SOAP calls to manage books.
 */
class BookService extends MainService
{
    /**
     * A book was added successfully.
     */
    const BOOK_ADDED_SUCCESSFULLY = 'A new book was created successful.';

    /**
     * A book was found successfully.
     */
    const BOOK_FOUND = 'Book found';

    /**
     * A book was not found.
     */
    const BOOK_NOT_FOUND = 'Book not found';

    /**
     * A book was updated successfully.
     */
    const BOOK_UPDATED_SUCCESSFULLY = 'Book updated successfully';

    /**
     * A book was deleted successfully.
     */
    const BOOK_DELETED = 'Book deleted successfully';

    /**
     * Books were successfully found.
     */
    const BOOKS_FOUND = 'Books found';

    /**
     * Book list is empty.
     */
    const BOOK_LIST_IS_EMTPY = 'There are no books in your list.';

    /**
     * Allows users add books to their accounts.
     *
     * @param string $title the title of the book
     * @param string $token users subsciption token
     *
     * @return array Response array with new book added
     */
    public function AddBook(string $title, string $token) : array
    {
        if ($user = UserRepository::findUserByToken($token)) {
            $book = BookRepository::createBook($user, $title);

            return $this->respond($this->getBookResponse($book, self::BOOK_ADDED_SUCCESSFULLY), 201);
        } else {
            return $this->respond($this->getInvalidTokenResponse($token), 400);
        }
    }

    /**
     * Allows users to get a book from their books.
     *
     * @param int    $id    the ID of the book to get.
     * @param string $token Users subscription token
     *
     * @return array Response array with book found
     */
    public function GetBook(int $id, string $token)
    {
        if ($user = UserRepository::findUserByToken($token)) {
            return ($book = BookRepository::findById($user, $id))
            ? $this->respond($this->getBookResponse($book, self::BOOK_FOUND), 200)
            : $this->respond($this->getMessageResponse(self::BOOK_NOT_FOUND), 404);
        } else {
            return $this->respond($this->getInvalidTokenResponse($token), 400);
        }
    }

    /**
     * Allows users to get their books.
     *
     * @param string $token Subscription token
     *
     * @return array Response array with list of books
     */
    public function GetBooks(string $token)
    {
        if ($user = UserRepository::findUserByToken($token)) {
            $books = BookRepository::findAll($user);

            return count($books) > 0
            ? $this->respond($this->getBooksResponse($books, self::BOOKS_FOUND), 200)
            : $this->respond($this->getMessageResponse(self::BOOK_LIST_IS_EMTPY), 404);
        } else {
            return $this->respond($this->getInvalidTokenResponse($token), 400);
        }
    }

    /**
     * Allows users to update the title of their books.
     *
     * @param int    $id       The ID of the book to update
     * @param string $newTitle the new title for the book
     * @param string $token    Users subscription token
     *
     * @return array The response array with update book
     */
    public function UpdateBook(int $id, string $newTitle, string $token)
    {
        if ($user = UserRepository::findUserByToken($token)) {
            if ($book = BookRepository::findById($user, $id)) {
                $book = BookRepository::updateBook($book, $newTitle);

                return $this->respond($this->getBookResponse($book, self::BOOK_UPDATED_SUCCESSFULLY), 200);
            } else {
                return $this->respond($this->getMessageResponse(self::BOOK_NOT_FOUND), 404);
            }
        } else {
            return $this->respond($this->getInvalidTokenResponse($token), 400);
        }
    }

    /**
     * Allows users to delete one of their books.
     *
     * @param int    $id    The ID of the book to delete
     * @param string $token The subscription token
     *
     * @return array response array with deleted information
     */
    public function DeleteBook(int $id, string $token)
    {
        if ($user = UserRepository::findUserByToken($token)) {
            if ($book = BookRepository::findById($user, $id)) {
                $book->delete();

                return $this->respond($this->getMessageResponse(self::BOOK_DELETED), 204);
            } else {
                return $this->respond($this->getMessageResponse(self::BOOK_NOT_FOUND), 404);
            }
        } else {
            return $this->respond($this->getInvalidTokenResponse($token), 400);
        }
    }

    /**
     * Response with found book.
     *
     * @param Book   $book    Book that was found
     * @param string $message Message saying book was found
     *
     * @return [array]
     */
    private function getBookResponse(Book $book, string $message) : array
    {
        return [
            'book' => [
                'id'    => $book->id,
                'title' => $book->title,
            ],
            'message' => $message,
        ];
    }

    /**
     * Response with found books.
     *
     * @param array  $books   The books to be sent to the user
     * @param string $message The message to send to the user
     *
     * @return [array]
     */
    private function getBooksResponse(array $books, string $message) : array
    {
        return [
            'books'   => $books,
            'message' => $message,
        ];
    }
}
