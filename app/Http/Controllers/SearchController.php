<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addBookSearch(Request $request)
    {
        $str = $request['str'];
        $id = $request['id'];

        if ($id == 'name') {
            $source = DB::table('lib_books')
                ->select('lib_books.name')
                ->where('lib_books.name', 'like', '%' . $str . '%')
                ->get();
        }
        elseif ($id == 'author') {
            $source = DB::table('authors')
                ->select('authors.name')
                ->where('authors.name', 'like', '%' . $str . '%')
                ->get();
        }
        elseif ($id == 'genre') {
            $source = DB::table('genres')
                ->select('genres.name')
                ->where('genres.name', 'like', '%' . $str . '%')
                ->get();
        }
        elseif ($id == 'tags') {
            $source = DB::table('tags')
                ->select('tags.name')
                ->where('tags.name', 'like', '%' . $str . '%')
                ->get();
        }
        else {
            $source = [];
        }

        return json_encode($source);
    }

    public function searchBooks(Request $request)
    {
        $str_book = $request['str_book'];
        $str_author = $request['str_author'];
        $str_year = $request['str_year'];
        $str_genre = $request['str_genre'];

        $arr_tags = $request['arr_tags'];

        if($arr_tags == '') {

            $source = DB::table('lib_books')
                ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
                ->join('authors', 'authors.id', '=', 'authors_books.author_id')
                ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
                ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw("(
                SELECT sum(reviews.rating) 
                FROM reviews
                WHERE reviews.book_id = lib_books.id
                ) as rating"))
                ->where([
                    ['lib_books.name', 'like', '%' . $str_book . '%'],
                    ['lib_books.year', 'like', '%' . $str_year . '%'],
                    ['genres.name', 'like', '%' . $str_genre . '%'],
                ])
                ->whereIn('lib_books.id',function($query) {
                    $query->select('book_id')->from('user_books');
                })
                ->groupBy('lib_books.id')
                ->orderBy('rating', 'DESC')
                ->having('author', 'like', '%' . $str_author . '%')
                ->get();
        }
        else {
            $arr = [];
            $i = 0;
            foreach (explode(',', $arr_tags) as $tag) {
                $tags_books = DB::table('tags_books')
                    ->join('tags', 'tags.id', '=', 'tags_books.tag_id')
                    ->distinct()
                    ->select('tags_books.book_id as book_id')
                    ->where([
                        ['tags.name', 'like', '%' . $tag . '%'],
                    ])
                    ->get()
                    ->toArray();

                foreach ($tags_books as $obj) {
                    $arr[] = $obj->book_id;
                }
                $i++;
            }

            $arr2 = array_count_values($arr);
            foreach($arr2 as $key => $val) {
                if ($val < $i)
                    unset($arr2[$key]);
            }

            $source = DB::table('lib_books')
                ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
                ->join('authors', 'authors.id', '=', 'authors_books.author_id')
                ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
                ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw("(
                    SELECT sum(reviews.rating) 
                    FROM reviews
                    WHERE reviews.book_id = lib_books.id
                    ) as rating"))
                ->where([
                    ['lib_books.name', 'like', '%' . $str_book . '%'],
                    ['lib_books.year', 'like', '%' . $str_year . '%'],
                    ['genres.name', 'like', '%' . $str_genre . '%'],
                ])
                ->whereIn('lib_books.id', array_keys($arr2))
                ->whereIn('lib_books.id',function($query) {
                    $query->select('book_id')->from('user_books');
                })
                ->groupBy('lib_books.id')
                ->orderBy('rating', 'DESC')
                ->having('author', 'like', '%' . $str_author . '%')
                ->get();
        }
        return json_encode($source);
    }
}
