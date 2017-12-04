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

use App\Services\GoogleBooksSearch;


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

    public function addBookSearch(GoogleBooksSearch $google, Request $request)
    {
//        $str = $request['str'];
//        $id = $request['id'];
//
//        if ($id == 'name') {
//        $source = DB::table('lib_books')
//            ->select('lib_books.name')
//            ->where('lib_books.name', 'like', '%' . $str . '%')
//            ->get();
//        }
//
//        elseif ($id == 'author') {
//            $source = DB::table('authors')
//                ->select('authors.name')
//                ->where('authors.name', 'like', '%' . $str . '%')
//                ->get();
//        }
//        else $source = [];
//
//        return json_encode($source);





        $str = $request['str'];
        $id = $request['id'];

        $result = $google->getBooks($str);
//        , 'Walden', 'Henry David Thoreau');


        if($id == 'name') {
            $source = [];
            foreach ($result as $item) {
                $source[] = [
                    'name' => $item['volumeInfo']['title'],
//                    'author' => $item['volumeInfo']['authors'],
//                    'genre' => $item['volumeInfo']['categories'],
//                    'year' => $item['volumeInfo']['publishedDate'],
//                    'description' => $item['volumeInfo']['description'],
//                    'photo' => $item['volumeInfo']['imageLinks']['thumbnail'],
                ];

            }
        }

        elseif ($id == 'author') {
            $source = [];
            foreach ($result as $item) {
                $source[] = [
//                    'name' => $item['volumeInfo']['title'],
                    'author' => $item['volumeInfo']['authors'],
//                    'genre' => $item['volumeInfo']['categories'],
//                    'year' => $item['volumeInfo']['publishedDate'],
//                    'description' => $item['volumeInfo']['description'],
//                    'photo' => $item['volumeInfo']['imageLinks']['thumbnail'],
                ];

            }
        }

        else $source = [];

        return json_encode($source);

    }

    protected function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|max:'.Now()->year,
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
        ]);

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $file_name = time() . '_' . $_FILES['photo']['name'];
            $file->move(public_path() . '/images/books', $file_name);
        }
        else {
            $file_name = '';
        }

        $book = LibBook::where('name', $request->get('name'))->first();

        if (!$book) {
            $book = LibBook::create([
                'name' => $request->get('name'),
                'year' => $request->get('year'),
                'genre_id' => $request->get('genre'),
                'description' => 'Lorem ipsum dolor sit amet',
                'photo' => $file_name,
            ]);
        }

//        $author = Author::find($request->get('author'));
        $author = Author::where('name', $request->get('author'))->first();

        if (!$author) {
            $author = Author::create([
                'name' => $request->get('author'),
            ]);
        }

        $user = User::find(Auth::user()->id);

        $book->authors()->save($author);
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
