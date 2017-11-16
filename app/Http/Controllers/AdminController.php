<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Author;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function admin_users()
    {
        $users = User::all();
        return view('admin_users', array('users' => $users));
    }

    protected function admin_books()
    {
        $books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author')
            ->get();

        return view('admin_books', array('books' => $books));
    }

    protected function admin_authors()
    {
        $authors = Author::all();
        return view('admin_authors', array('authors' => $authors));
    }

    protected function admin_genres()
    {
        $genres = DB::table('genres')->get();
        return view('admin_genres', array('genres' => $genres));
    }

    protected function admin_orders()
    {
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.taker_id')
            ->join('users as users1', 'users1.id', '=', 'orders.giving_id')
            ->join('lib_books', 'orders.book_id', '=', 'lib_books.id')
            ->select('orders.*', 'users.name as taker', 'users1.name as giving', 'lib_books.name as book', 'orders.id as order_id')
            ->get();
        return view('admin_orders', array('orders' => $orders));
    }

    protected function admin_reviews()
    {
        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('lib_books', 'reviews.book_id', '=', 'lib_books.id')
            ->select('users.username', 'reviews.*', 'lib_books.name as book')
            ->get();
        return view('admin_reviews', array('reviews' => $reviews));
    }

}
