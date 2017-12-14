<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class BookDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bookDetails($http_response_header)
    {
        $book_info = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw('group_concat(authors.name) as author'), DB::raw("(
                SELECT sum(reviews.rating) 
                FROM reviews
                WHERE reviews.book_id = lib_books.id
                ) as rating"))
            ->where('lib_books.id', $http_response_header)
            ->groupBy('lib_books.id')
            ->first();

        $users = DB::table('user_books')
            ->join('users', 'users.id', '=', 'user_books.user_id')
            ->select('users.*')
            ->where('user_books.book_id', $http_response_header)
            ->get();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.username', 'users.photo', 'reviews.*')
            ->where('reviews.book_id', $http_response_header)
            ->get();

        $user_reviews = DB::table('reviews')
            ->select('reviews.user_id')
            ->where([
                ['reviews.book_id', $http_response_header],
                ['reviews.user_id', Auth::user()->id]
            ])
            ->first();

        if ($book_info) {
            return view('book_details', array(
                'book_info' => $book_info,
                'users' => $users,
                'reviews' => $reviews,
                'user_reviews' => $user_reviews,
            ));
        }
        else {
            return back();
        }
    }
}
