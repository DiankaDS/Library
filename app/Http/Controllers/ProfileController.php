<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function user_profile()
    {
        $user_books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('user_books', 'lib_books.id', '=', 'user_books.book_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author', 'user_books.user_id as user')
            ->where('user_books.user_id', Auth::user()->id)
            ->get();
        return view('profile', array('user_info' => Auth::user(), 'user_books' => $user_books));
    }
}
