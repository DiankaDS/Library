<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LibBook;
use App\AuthorsBook;

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

        $book->authors()->save($author);
//
//        $author =
//            Author::create([
//                'name' => $request->get('author'),
//
//            ]);

        return [$book];
    }

}
