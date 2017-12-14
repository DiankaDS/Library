<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Review;
use Auth;
use App\Tag;
use App\Author;

class HomeController extends Controller
{
    public function index()
    {
        $books = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw("(
                SELECT sum(reviews.rating) 
                FROM reviews
                WHERE reviews.book_id = lib_books.id
                ) as rating"))
            ->whereIn('lib_books.id',function($query) {
                $query->select('book_id')->from('user_books');
            })
            ->groupBy('lib_books.id')
            ->orderBy('rating', 'DESC')
            ->simplePaginate(12);

        $genres = DB::table('genres')->get();

        return view('home', [
            'books' => $books,
            'genres' => $genres,
        ]);
    }


    public function homeSearch()
    {
        $books = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw("(
                SELECT sum(reviews.rating) 
                FROM reviews
                WHERE reviews.book_id = lib_books.id
                ) as rating"))
            ->whereIn('lib_books.id',function($query) {
                $query->select('book_id')->from('user_books');
            })
            ->groupBy('lib_books.id')
            ->orderBy('rating', 'DESC')
            ->simplePaginate(6);

        $genres = DB::table('genres')->get();

        $tags = Tag::all();

        $years = DB::table('lib_books')
            ->select('lib_books.year as name')
            ->whereIn('lib_books.id',function($query) {
                $query->select('book_id')->from('user_books');
            })
            ->orderBy('name', 'DESC')
            ->get();


//        $authors = Author::all();

        return view('home_search', [
            'books' => $books,
            'genres' => $genres,
            'tags' => $tags,
            'years' => $years,
//            'authors' => $authors,
        ]);
    }
}
