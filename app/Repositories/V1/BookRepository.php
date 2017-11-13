<?php

namespace App\Repositories\V1;

use App\Models\V1\Book;
use App\Models\V1\User;

class BookRepository
{
    public static function createBook(User $user, string $title)
    {
        return $user->books()->create([
            'title' => $title,
        ]);
    }

    public static function findById(User $user, string $id)
    {
        return $user->books()->find($id);
    }

    public static function findAll(User $user, bool $sort = false)
    {
        $books = $user->books->map(function (Book $book) {
            return [
                'id'    => $book->id,
                'title' => $book->title,
            ];
        })->toArray();
        return $sort ? quick_sort($books, function ($currentBook, $pivotBook) : bool {
            return strcmp($currentBook["title"], $pivotBook["title"]) < 0;
        }) : $books;
    }

    public static function updateBook(Book $book, string $newTitle)
    {
        $book->update([
            'title' => $newTitle,
        ]);

        return $book;
    }
}
