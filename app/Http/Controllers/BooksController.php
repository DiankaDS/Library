<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\LibBook;

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
            //'author_id' => $request->get('author'),
            'genre_id' => $request->get('genre'),
            'description' => '1',
        ]);

        return $book;

        //CreateLibBooksTable::create($data);
        //return back()->with('success', 'Book has been added');
    }






}
