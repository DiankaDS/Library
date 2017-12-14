<?php

namespace App\Http\Controllers;

//use App\Author;
use App\User;
use App\LibBook;
//use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Image;


class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
