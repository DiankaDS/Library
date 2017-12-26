<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LibBook;
use App\Review;
use Illuminate\Support\Facades\DB;

class AdminBooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminBooks()
    {
        $books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->leftJoin('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->leftJoin('authors', 'authors.id', '=', 'authors_books.author_id')
//            ->leftJoin('tags_books', 'tags_books.book_id', '=', 'lib_books.id')
//            ->leftJoin('tags', 'tags.id', '=', 'tags_books.tag_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw('group_concat(authors.name) as author'))
//                , DB::raw('group_concat(tags.name) as tag')
            ->groupBy('lib_books.id', 'genres.name')
//            ->get();
            ->paginate(12);

        $tags = DB::table('lib_books')
            ->leftJoin('tags_books', 'tags_books.book_id', '=', 'lib_books.id')
            ->leftJoin('tags', 'tags.id', '=', 'tags_books.tag_id')
//            ->select('lib_books.id as book_id',  DB::raw('group_concat(tags.name) as tag'))
            ->select('lib_books.id as book_id',  'tags.name as tag')
//            ->groupBy('lib_books.id')
            ->get();

        $confirm_delete_book_message = 'Are you sure to delete this book?';

        $all_tags = DB::table('tags')->get();

        return view('admin/admin_books', array(
            'books' => $books,
            'tags' => $tags,
            'all_tags' => $all_tags,
            'confirm_delete_book_message' => $confirm_delete_book_message,
        ));
    }

    protected function adminBookDelete(Request $request)
    {
        $book_id = $request->get('admins_book_id');

        $book = LibBook::find($book_id);

        Review::where('book_id', $book_id)->delete();

        DB::table('formats_users_books')
            ->join('user_books', 'formats_users_books.user_book_id', '=', 'user_books.id')
            ->where('book_id', $book_id)
            ->delete();

        $book->users()->detach();
        $book->authors()->detach();
        $book->tags()->detach();
        $book->delete();

        $message = "Book deleted!";
        return back()->with('status', $message);
    }
}
