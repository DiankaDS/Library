<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->leftJoin('reviews', 'reviews.book_id', '=', 'lib_books.id')

            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author', DB::raw('SUM(reviews.rating) as rating'))
            ->groupBy('lib_books.id', 'genres.name', 'authors.name')
            ->get();

        return view('home', ['books' => $books]);
    }

}
