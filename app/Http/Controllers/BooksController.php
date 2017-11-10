<?php

namespace App\Http\Controllers;

use App\Author;
use App\User;
use App\LibBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Auth\ProfileController;
use Auth;

class BooksController extends Controller
{

    public function add_book_form()
    {
        $genres = DB::table('genres')->get();
        $authors = DB::table('authors')->get();
        return view('add_book_form', array('genres' => $genres, 'authors' => $authors));
    }

    protected function create(Request $request)
    {
        $book =
            LibBook::create([
            'name' => $request->get('name'),
            'year' => $request->get('year'),
            'genre_id' => $request->get('author'),
            'description' => '1',
            //'user_id' => get[],
        ]);

        $author = Author::find($request->get('author'));
        $user = User::find(Auth::user()->id);

        $book->authors()->save($author);
        $book->users()->save($user);
//
//        $author =
//            Author::create([
//                'name' => $request->get('author'),
//
//            ]);

        return [$book, $author, $user];
    }

}
