<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Review;
use Auth;

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
}
