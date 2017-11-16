<?php

namespace App\Http\Controllers;

use App\Author;
use App\User;
use App\LibBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\Auth\ProfileController;
use Auth;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'genre_id' => $request->get('author'),
            'description' => '1',
        ]);

        $author = Author::find($request->get('author'));
        $user = User::find(Auth::user()->id);

        $book->authors()->save($author);
        $book->users()->save($user);

        return redirect('profile');
    }

    protected function delete(Request $request){

        $user = User::find(Auth::user()->id);
        $user->books()->detach($request->get('id'));

        return redirect('profile');
    }

    public function book_details($http_response_header)
    {
//        $book_info = DB::table('lib_books')
//            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
//            ->join('user_books', 'user_books.book_id', '=', 'lib_books.id')
//            ->join('users', 'users.id', '=', 'user_books.user_id')
//            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author', 'users.name as owner')
//            ->where('lib_books.id', $http_response_header)
//            ->get();

        $book_info = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author')
            ->where('lib_books.id', $http_response_header)
            ->first();

        $users = DB::table('user_books')
            ->join('users', 'users.id', '=', 'user_books.user_id')
            ->select('users.*')
            ->where('user_books.book_id', $http_response_header)
            ->get();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.username', 'reviews.*')
            ->where('reviews.book_id', $http_response_header)
            ->get();

//        $book_rating = DB::table('reviews')
//            ->where('reviews.book_id', $http_response_header)
//            ->sum('reviews.rating');

        return view('book_details', ['book_info' => $book_info, 'users' => $users, 'reviews' => $reviews]);

    }

    public function add_review(Request $request)
    {
        Review::create([
            'book_id' => $request->get('book_id'),
            'user_id' => Auth::user()->id,
            'text' => $request->get('review'),
            'rating' => $request->get('rating'),
        ]);
        return back();
    }

}
