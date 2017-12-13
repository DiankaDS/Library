<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class WishesController extends Controller
{
    public function wishes()
    {
        $wished_books = DB::table('wishes')
            ->join('lib_books', 'lib_books.id', '=', 'wishes.book_id')
//            ->join('users', 'users.id', '=', 'wishes.user_id')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw("(
                SELECT group_concat(authors.name)
                FROM authors 
                    INNER JOIN authors_books ON authors_books.author_id = authors.id
                WHERE authors_books.book_id = lib_books.id
                ) as author"
            ), DB::raw("(
                SELECT count(id) 
                FROM wishes as w
                WHERE w.book_id = wishes.book_id
                ) as votes"))
//            ->whereNotIn('lib_books.id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
            ->groupBy('lib_books.id')
            ->orderBy('votes', 'DESC')
            ->simplePaginate(12);

        $vote_users = DB::table('wishes')
            ->join('users', 'users.id', '=', 'wishes.user_id')
            ->select('users.username', 'wishes.book_id', 'wishes.user_id')
            ->get();

        $auth_books_votes = DB::table('wishes')
            ->select('wishes.book_id')
            ->where('wishes.user_id', '=', Auth::user()->id)
            ->get();


        return view('wishes', [
            'wished_books' => $wished_books,
            'vote_users' => $vote_users,
            'auth_books_votes' => $auth_books_votes,
        ]);
    }

    public function addVote(Request $request)
    {
        DB::table('wishes')->insert([
            'book_id' => $request->get('book_id'),
            'user_id' => Auth::user()->id,
        ]);
        $message = "Your vote saved!";

        return back()->with('status', $message);
    }

    public function deleteVote(Request $request)
    {
        DB::table('wishes')
            ->where([
                ['book_id', $request->get('book_id')],
                ['user_id', Auth::user()->id]
            ])
        ->delete();
        $message = "Your vote deleted!";

        return back()->with('status', $message);
    }
}