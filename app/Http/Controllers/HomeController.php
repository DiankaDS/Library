<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Review;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->leftJoin('reviews', 'reviews.book_id', '=', 'lib_books.id')

            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw('SUM(reviews.rating) as rating'))
            ->groupBy('lib_books.id')
//            ->get();
            ->simplePaginate(12);

        $genres = DB::table('genres')->get();

        return view('home', [
            'books' => $books,
            'genres' => $genres,
        ]);
    }

    public function searchBooks(Request $request)
    {
        $str_book = $request['str_book'];
        $str_author = $request['str_author'];
        $str_year = $request['str_year'];
        $str_genre = $request['str_genre'];

        $arr_tags = $request['arr_tags'];

        $source = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->leftJoin('reviews', 'reviews.book_id', '=', 'lib_books.id')

//            ->leftJoin('tags_books', 'tags_books.book_id', '=', 'lib_books.id')
//            ->leftJoin('tags', 'tags.id', '=', 'tags_books.tag_id')

            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw('SUM(reviews.rating) as rating'))
            ->where([
                ['lib_books.name', 'like', '%' . $str_book . '%'],
                ['lib_books.year', 'like', '%' . $str_year . '%'],
                ['genres.name', 'like', '%' . $str_genre . '%'],
//                ['tags.name', 'like', '%' . $arr_tags . '%'],
            ])
            ->groupBy('lib_books.id')
            ->having('author', 'like', '%' .$str_author. '%')
            ->get();

        return json_encode($source);
    }
}
