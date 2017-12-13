<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishesController extends Controller
{
    public function wishes()
    {
        $wished_books = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw('group_concat(authors.name) as author'))
            ->whereNotIn('lib_books.id',function($query) {
                $query->select('book_id')->from('user_books');
            })
            ->groupBy('lib_books.id')
            ->simplePaginate(12);

        return view('wishes', [
            'wished_books' => $wished_books,
        ]);
    }
}