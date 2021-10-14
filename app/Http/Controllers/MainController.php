<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function index()
    {
        $authors = Author::all();
        $books = Book::all();
        $book_authors = BookAuthor::all();
        $bookIds = DB::table('book_authors')
            ->select('book_id')
            ->whereNotNull('author_id')
            ->get();
        $ids = [];
        foreach ($bookIds as $id) {
            $ids[] = $id->book_id;
        }
        $without_authors = Book::all()
            ->whereNotIn('id', $ids);

        return view('index', [
            'authors' => $authors,
            'books' => $books,
            'book_authors' => $book_authors,
            'without_authors' => $without_authors
        ]);
    }

    // сумма книг по автору
    public function getBooks()
    {
        $bookIds = DB::table('book_authors')
            ->select('book_id')
            ->where('author_id', $_POST['author_id'])
            ->get();
        $price = 0;
        foreach ($bookIds as $bookId) {
            $id = get_object_vars($bookId);
            $price += DB::table('books')
                ->where('id', $id)
                ->sum('price');
        }
        echo $price;
    }

    // список авторов по книге
    public function getAuthors()
    {
        $authorIds = DB::table('book_authors')
            ->select('author_id')
            ->where('book_id', $_POST['book_id'])
            ->get();
        $newAuthors = [];
        foreach ($authorIds as $authorId) {
            $author = get_object_vars($authorId);
            $newAuthors[] = DB::table('authors')
                ->select('fio')
                ->where('id', $author)
                ->get();
        }
        $this->debug($newAuthors);
    }

    public function debug($array)
    {
        foreach ($array as $arr) {
            $author = json_decode($arr)[0]->fio;
            echo '<pre>' . print_r($author, true) . '</pre>';
        }
    }

}
