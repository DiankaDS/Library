<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BooksController extends Controller
{
    public function add_book_form()
    {
        $genres = DB::table('genres')->get();
        $authors = DB::table('authors')->get();
        return view('add_book_form', array('genres' => $genres, 'authors' => $authors));
    }




//    protected function create(array $data)
//    {
//        //return
//            CreateLibBooksTable::create([
//            'name' => $data['name'],
//            'year' => $data['year'],
//            //'author' => $data['author'],
//            'genre' => $data['genre'],
//        ]);
//
//
//        //CreateLibBooksTable::create($data);
//        return back()->with('success', 'Product has been added');
//    }






}
