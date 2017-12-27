<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Review;
use Auth;
use App\Tag;
use App\Format;

class HomeController extends Controller
{
//    public function index()
//    {
//        $books = DB::table('lib_books')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
//            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'), DB::raw("(
//                SELECT sum(reviews.rating)
//                FROM reviews
//                WHERE reviews.book_id = lib_books.id
//                ) as rating"))
//            ->whereIn('lib_books.id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
//            ->groupBy('lib_books.id')
//            ->orderBy('rating', 'DESC')
//            ->paginate(12);
//
//        $genres = DB::table('genres')->get();
//
//        return view('home', [
//            'books' => $books,
//            'genres' => $genres,
//        ]);
//    }


    public function homeSearch()
    {
        $books = DB::table('lib_books')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'),
                DB::raw("(
                SELECT round(avg(reviews.rating), 1)
                FROM reviews
                WHERE reviews.book_id = lib_books.id
                ) as rating"),
                DB::raw("(SELECT group_concat(distinct formats.name)
                FROM formats
                INNER JOIN formats_users_books ON formats_users_books.format_id = formats.id
                INNER JOIN user_books ON formats_users_books.user_book_id = user_books.id
                WHERE user_books.book_id = lib_books.id
                ) as formats")
            )
//            ->whereIn('lib_books.id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
            ->groupBy('lib_books.id')
            ->orderBy('rating', 'DESC')
            ->paginate(6);

        $genres = DB::table('genres')->get();
        $tags = Tag::all();
        $formats = Format::all();

        $years = DB::table('lib_books')
            ->select('lib_books.year as name')
            ->distinct()
//            ->whereIn('lib_books.id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
            ->orderBy('name', 'DESC')
            ->get();

        return view('home_search', [
            'books' => $books,
            'genres' => $genres,
            'tags' => $tags,
            'years' => $years,
            'formats' => $formats,
        ]);
    }

    public function homeSearchBooks(Request $request)
    {
        $input = $request['input'];
        $genres_id = $request['genres'];
        $tags_id = $request['tags'];
        $years = $request['years'];
        $rating = $request['rating'];
        $formats_id = $request['formats'];

        $input_books =  DB::table('lib_books')
            ->select('lib_books.id as id')
            ->distinct()
            ->where('lib_books.name', 'like', '%' . $input . '%')
//            ->whereIn('lib_books.id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
        ;

        $input_all = DB::table('authors_books')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('authors_books.book_id as id')
            ->distinct()
            ->where('authors.name', 'like', '%' . $input . '%')
//            ->whereIn('authors_books.book_id',function($query) {
//                $query->select('book_id')->from('user_books');
//            })
            ->union($input_books)
            ->get()
            ->toArray();

        $books_id = [];

        if($input_all) {
            foreach ($input_all as $obj) {
                $books_id[] = $obj->id;
            }

            $books = DB::table('lib_books')
                ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
                ->join('authors', 'authors.id', '=', 'authors_books.author_id')
                ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
                ->select('lib_books.*', DB::raw('group_concat(authors.name) as author'),
                    DB::raw("(
                    SELECT round(avg(reviews.rating), 1)
                    FROM reviews
                    WHERE reviews.book_id = lib_books.id
                    ) as rating"),
                    DB::raw("(SELECT group_concat(distinct formats.name)
                    FROM formats
                    INNER JOIN formats_users_books ON formats_users_books.format_id = formats.id
                    INNER JOIN user_books ON formats_users_books.user_book_id = user_books.id
                    WHERE user_books.book_id = lib_books.id
                    ) as formats")
                )
                ->whereIn('lib_books.id', $books_id)
                ->groupBy('lib_books.id')
                ->orderBy('rating', 'DESC');

            if ($genres_id != '') {
                $books = $books->whereIn('lib_books.genre_id', $genres_id);
            }

            if ($tags_id != '') {
                $arr = [];
                $i = 0;

                foreach ($tags_id as $tag) {
                    $tags = DB::table('tags_books')
                        ->select('tags_books.book_id as id')
                        ->distinct()
                        ->where('tags_books.tag_id', $tag)
                        ->get()
                        ->toArray();

                    foreach ($tags as $obj) {
                        $arr[] = $obj->id;
                    }
                    $i++;
                }

                $arr2 = array_count_values($arr);
                foreach($arr2 as $key => $val) {
                    if ($val < $i)
                        unset($arr2[$key]);
                }

                $books = $books->whereIn('lib_books.id', array_keys($arr2));
            }

            if ($years != '') {
                $books = $books->whereIn('lib_books.year', $years);
            }

            if ($rating) {
                $rating_books = DB::table('lib_books')
                    ->select('lib_books.id as book_id', DB::raw("(
                    SELECT round(avg(reviews.rating), 1)
                    FROM reviews
                    WHERE reviews.book_id = lib_books.id
                    ) as rating"))
                    ->distinct()
                    ->having('rating', '>=', $rating)
                    ->having('rating', '<', $rating + 1)
                    ->groupBy('lib_books.id')
                    ->get()
                    ->toArray();

                $rating_id = [];

                foreach ($rating_books as $obj) {
                    $rating_id[] = $obj->book_id;
                }

                $books = $books->whereIn('lib_books.id', $rating_id);
            }

            if ($formats_id != '') {
                $arr = [];

                foreach ($formats_id as $format) {
                    $formats = DB::table('formats_users_books')
                        ->join('user_books', 'user_books.id', '=', 'formats_users_books.user_book_id')
                        ->select('user_books.book_id as id')
                        ->distinct()
                        ->where('formats_users_books.format_id', $format)
                        ->get()
                        ->toArray();

                    foreach ($formats as $obj) {
                        $arr[] = $obj->id;
                    }
                }

                $books = $books->whereIn('lib_books.id', $arr);
            }

            if($books) {
//                $source = $books->get();
                $source = $books->paginate(6);
            }

            else
                $source = [];
        }

        else
            $source = [];

        return json_encode($source);
    }
}
