<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Format;
use Illuminate\Http\Request;
use App\Author;
use App\User;
use App\LibBook;
use Illuminate\Support\Facades\DB;
use Auth;
use Image;

class CreateBookController extends Controller
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

    protected function createBook(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer|max:'.Now()->year,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $link = '';
        $price = 0;

        if ($request->get('link')) {
            $link = $request->get('link');
        }
        elseif ($request->file('file')) {
            $book_file = $request->file('file');
            $book_file_move_name = time() . '_' . $_FILES['file']['name'];
            $book_file->move(public_path() . '/files/', $book_file_move_name);
            $link = '/files/' . $book_file_move_name;
        }

        if ($request->get('price')) {
            $price = $request->get('price');
        }

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

        foreach (explode(',', $request->get('author')) as $val) {

            $author = Author::where('name', $val)->first();

            if (!$author) {
                $author = Author::create([
                    'name' => $val,
                ]);
            }

            $author_book = $book->authors()->where('name', $val)->first();

            if(!$author_book) {
                $book->authors()->save($author);
            }
        }

        foreach (explode(' ', $request->get('span_tags')) as $val) {
            $tag = Tag::where('name', $val)->first();
            $book->tags()->save($tag);
        }

        if ($request->get('wish') == 0) {
            if (Auth::user()->role_id != 0) {
                $user = User::find(Auth::user()->id);
                $book->users()->save($user, ['link' => $link, 'price' => $price, 'is_approve' => 1]);
            }
            else {
                $user = User::find(Auth::user()->id);
                $book->users()->save($user, ['link' => $link, 'price' => $price]);
            }

            $message = "Book created!";

            foreach (explode(' ', $request->get('span_formats')) as $val) {

                $format = Format::where('name', $val)->first()->id;

                $user_book_id = DB::table('user_books')->max('id');

                DB::table('formats_users_books')->insert([
                    'format_id' => $format,
                    'user_book_id' => $user_book_id,
                ]);
            }
        }
        else {
            DB::table('wishes')->insert([
                'book_id' => $book->id,
                'user_id' => Auth::user()->id,
            ]);

            $message = "Wish created!";
        }

        return back()->with('status', $message);
    }
}
