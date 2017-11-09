<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function add_book_form()
    {
        return view('add_book_form');
    }
}
