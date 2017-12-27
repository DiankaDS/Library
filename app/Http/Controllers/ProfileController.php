<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
//use App\Order;
//use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userProfile($http_response_header)
    {
        $user_id = $http_response_header;

        $user_books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('user_books', 'lib_books.id', '=', 'user_books.book_id')
            ->select('lib_books.*', 'genres.name as genre', 'user_books.user_id as user', DB::raw('group_concat(authors.name) as author'),
                DB::raw("(SELECT group_concat(formats.name)
                FROM formats
                INNER JOIN formats_users_books ON formats_users_books.format_id = formats.id
                INNER JOIN user_books ON formats_users_books.user_book_id = user_books.id
                WHERE user_books.book_id = lib_books.id
                AND user_books.user_id = $user_id
                ) as formats")
            )
            ->where([
                ['user_books.user_id', $user_id],
                ['user_books.is_approve', 1],
            ])
            ->groupBy('lib_books.id', 'genres.name', 'user_books.user_id')
            ->paginate(6);

        $user_books_count = DB::table('user_books')
            ->where([
                ['user_books.user_id', $user_id],
                ['user_books.is_approve', 1],
            ])
            ->count();

        $confirm_delete_book_message = 'Are you sure to delete book?';
        $confirm_delete_profile_message = 'Are you sure to delete profile?';

        return view('profile', array(
            'user_info' => User::find($user_id),
            'user_books' => $user_books,
            'confirm_delete_book_message' => $confirm_delete_book_message,
            'confirm_delete_profile_message' => $confirm_delete_profile_message,
            'user_books_count' => $user_books_count,
        ));
    }
}
