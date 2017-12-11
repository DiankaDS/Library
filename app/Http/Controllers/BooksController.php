<?php

namespace App\Http\Controllers;

use App\Author;
use App\User;
use App\LibBook;
use App\Review;
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

    public function addBookForm()
    {
        $genres = DB::table('genres')->get();
        $authors = DB::table('authors')->get();
        return view('add_book_form', array(
            'genres' => $genres,
            'authors' => $authors
        ));
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

    protected function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|max:'.Now()->year,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required',
        ]);

        if ($request->get('google_photo')) {
            $file_name = $request->get('google_photo');
        }

        elseif ($request->file('photo')) {
            $file = $request->file('photo');
            $file_move_name = time() . '_' . $_FILES['photo']['name'];
            $file->move(public_path() . '/images/books', $file_move_name);
            $file_name = '/images/books/' . $file_move_name;
        }
        else {
            $file_name = '';
        }

        $genre = DB::table('genres')
            ->where('name', $request->get('genre'))
            ->first();

        if (!$genre) {
            $genre_id = DB::table('genres')->insertGetId([
                'name' => $request->get('genre'),
            ]);
        }
        else {
            $genre_id = $genre->id;
        }

        $book = LibBook::where('name', $request->get('name'))->first();

        if (!$book) {
            $book = LibBook::create([
                'name' => $request->get('name'),
                'year' => $request->get('year'),
                'genre_id' => $genre_id,
                'description' => $request->get('description'),
                'photo' => $file_name,
            ]);
        }

        $user = User::find(Auth::user()->id);

        foreach(explode(',', $request->get('author')) as $val) {

            $author = Author::where('name', $val)->first();

            if (!$author) {
                $author = Author::create([
                    'name' => $val,
                ]);
            }
            $book->authors()->save($author);
        }

        $book->users()->save($user);

        $message = "Book created!";

        return back()->with('status', $message);
    }

    protected function delete(Request $request){

        $user = User::find(Auth::user()->id);
        $user->books()->detach($request->get('id'));

        $message = "Book deleted!";
        return back()->with('status', $message);
    }

    public function bookDetails($http_response_header)
    {
        $book_info = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', DB::raw('group_concat(authors.name) as author'))
            ->where('lib_books.id', $http_response_header)
            ->groupBy('lib_books.id')
            ->first();

        $users = DB::table('user_books')
            ->join('users', 'users.id', '=', 'user_books.user_id')
            ->select('users.*')
            ->where('user_books.book_id', $http_response_header)
            ->get();

        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->select('users.username', 'users.photo', 'reviews.*')
            ->where('reviews.book_id', $http_response_header)
            ->get();

        $user_reviews = DB::table('reviews')
            ->select('reviews.user_id')
            ->where([
                ['reviews.book_id', $http_response_header],
                ['reviews.user_id', Auth::user()->id]
            ])
            ->first();

        if ($book_info) {
            return view('book_details', array(
                'book_info' => $book_info,
                'users' => $users,
                'reviews' => $reviews,
                'user_reviews' => $user_reviews,
            ));
        }
        else {
            return back();
        }
    }

    public function addReview(Request $request)
    {
        $request->validate([
            'review' => 'required|string|max:255',
        ]);

        if ($request->get('edit_review_id')) {
            $review = Review::find($request->get('edit_review_id'));
            $review->fill([
                'text' => $request->get('review')
            ])->save();
        }

        else {
            Review::create([
                'book_id' => $request->get('book_id'),
                'user_id' => Auth::user()->id,
                'text' => $request->get('review'),
                'rating' => $request->get('rating'),
            ]);
        }
        $message = "Your review saved!";

        return back()->with('status', $message);
    }

}
