<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function book_details($http_response_header)
    {
//        $book_info = DB::table('lib_books')
//            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
//            ->join('user_books', 'user_books.book_id', '=', 'lib_books.id')
//            ->join('users', 'users.id', '=', 'user_books.user_id')
//            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author', 'users.name as owner')
//            ->where('lib_books.id', $http_response_header)
//            ->get();

        $book_info = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author')
            ->where('lib_books.id', $http_response_header)
            ->first();

        $users = DB::table('user_books')
            ->join('users', 'users.id', '=', 'user_books.user_id')
            ->select('users.*')
            ->where('user_books.book_id', $http_response_header)
            ->get();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.username', 'reviews.*')
            ->where('reviews.book_id', $http_response_header)
            ->get();

//        $book_rating = DB::table('reviews')
//            ->where('reviews.book_id', $http_response_header)
//            ->sum('reviews.rating');

        return view('book_details', ['book_info' => $book_info, 'users' => $users, 'reviews' => $reviews]);

    }
}
