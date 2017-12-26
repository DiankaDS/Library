<?php

namespace App\Http\Controllers;

use App\LibBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewUpdateBook($http_response_header)
    {
        $book = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw('group_concat(authors.name) as author')
//                ,
//                DB::raw("(SELECT round(avg(reviews.rating), 1)
//                FROM reviews
//                WHERE reviews.book_id = lib_books.id
//                ) as rating"),
//                DB::raw("(SELECT group_concat(formats.name)
//                FROM formats
//                INNER JOIN formats_users_books ON formats_users_books.format_id = formats.id
//                INNER JOIN user_books ON formats_users_books.user_book_id = user_books.id
//                WHERE user_books.book_id = lib_books.id
//                ) as formats")
            )
            ->where('lib_books.id', $http_response_header)
            ->groupBy('lib_books.id')
            ->first();

        return view('update_book', array(
            'book' => $book,
        ));
    }

    public function updateBook(Request $request)
    {
        $book = LibBook::find($request->get('id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|max:'.Now()->year,
            'author' => 'required|string|max:255',
//            'genre' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $book->update($request->all());

        $message = "Book updated!";

        return back()->with('status', $message);
    }

//    public function uploadBookPhoto(Request $request)
//    {
//        $request->validate([
//            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//        ]);
//
//        $file = $request->file('photo');
//        $file_name = time().'_'.$_FILES['photo']['name'];
//        $file->move(public_path().'/images/books', $file_name);
//
//        $book = LibBook::find($request->get('id'));
//        $book->fill([
//            'photo' => $file_name,
//        ])->save();
//
//        $message = "Photo was upload!";
//
//        return back()->with('status', $message);
//    }
}
