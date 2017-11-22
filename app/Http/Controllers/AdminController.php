<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\LibBook;
use App\Author;
use App\Review;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function admin_users()
    {
        $users = User::all();
        $confirm_delete_profile_message = "Are you sure to delete this user?";
        $confirm_add_to_admin_message = "Are you sure to add this user to admin?";
        $confirm_delete_from_admin_message = "Are you sure to delete this user from admin?";

        return view('admin/admin_users', array(
            'users' => $users,
            'confirm_delete_profile_message' => $confirm_delete_profile_message,
            'confirm_add_to_admin_message' => $confirm_add_to_admin_message,
            'confirm_delete_from_admin_message' => $confirm_delete_from_admin_message,
        ));
    }

    protected function add_to_admin(Request $request)
    {
        $order = User::find($request->get('admins_user_id'));
        $order->admin = 1;
        $order->save();

        $message = "User added to admin!";
        return back()->with('status', $message);
    }

    protected function delete_from_admin(Request $request)
    {
        $order = User::find($request->get('admins_user_id'));
        $order->admin = 0;
        $order->save();

        $message = "User deleted from admin!";
        return back()->with('status', $message);
    }


    protected function admin_books()
    {
        $books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author')
            ->get();

        $confirm_delete_book_message = 'Are you sure to delete this book?';

        return view('admin/admin_books', array(
            'books' => $books,
            'confirm_delete_book_message' => $confirm_delete_book_message,
        ));
    }

    protected function admin_book_delete(Request $request)
    {
        $book_id = $request->get('admins_book_id');

        $book = LibBook::find($book_id);

        Review::where('book_id', $book_id)->delete();

        $book->users()->detach();
        $book->authors()->detach();
        $book->delete();

        $message = "Book deleted!";
        return back()->with('status', $message);
    }

    protected function admin_authors()
    {
        $authors = Author::all();
        $confirm_delete_author_message = 'Are you sure to delete this author?';
        return view('admin/admin_authors', array(
            'authors' => $authors,
            'confirm_delete_author_message' => $confirm_delete_author_message,
        ));
    }

    protected function admin_author_delete(Request $request)
    {
        $author = Author::find($request->get('admins_author_id'));

        $author->books()->detach();
        $author->delete();

        $message = "Author deleted!";
        return back()->with('status', $message);
    }

    protected function admin_author_create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::where('name', $request->get('name'))->first();

        if(!$author) {
                Author::create([
                    'name' => $request->get('name'),
                ]);

            $message = "Author created!";
        }
        else{
            $message = "Author already exists!";
        }

        return back()->with('status', $message);
    }

    protected function admin_genres()
    {
        $genres = DB::table('genres')->get();
        $confirm_delete_genre_message = 'Are you sure to delete this author?';
        return view('admin/admin_genres', array(
            'genres' => $genres,
            'confirm_delete_genre_message' => $confirm_delete_genre_message,
        ));
    }

    protected function admin_genre_delete(Request $request)
    {
        DB::table('genres')
            ->where('genres.id', $request->get('admins_genre_id'))
            ->delete();

        $message = "Genre deleted!";
        return back()->with('status', $message);
    }

    protected function admin_genre_create(Request $request)
    {
        $request->validate([
            'genre' => 'required|string|max:255',
        ]);

        DB::table('genres')->insert(
            ['name' => $request->get('genre')]
        );

        $message = "Genre created!";
        return back()->with('status', $message);
    }

    protected function admin_orders()
    {
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.taker_id')
            ->join('users as users1', 'users1.id', '=', 'orders.giving_id')
            ->join('lib_books', 'orders.book_id', '=', 'lib_books.id')
            ->select('orders.*', 'users.username as taker', 'users1.username as giving', 'lib_books.name as book', 'orders.id as order_id')
            ->get();

        $confirm_delete_order_message = 'Are you sure to delete this order?';
        return view('admin/admin_orders', array(
            'orders' => $orders,
            'confirm_delete_order_message' => $confirm_delete_order_message,
        ));
    }

    protected function admin_reviews()
    {
        $reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('lib_books', 'reviews.book_id', '=', 'lib_books.id')
            ->select('users.username', 'reviews.*', 'lib_books.name as book')
            ->get();

        $confirm_delete_review_message = 'Are you sure to delete this review?';
        return view('admin/admin_reviews', array(
            'reviews' => $reviews,
            'confirm_delete_review_message' => $confirm_delete_review_message,
        ));
    }

    protected function admin_review_delete(Request $request)
    {
        $review = Review::find($request->get('admins_review_id'));
        $review->delete();

        $message = "Review deleted!";
        return back()->with('status', $message);
    }
}
