<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function user_profile()
    {
        $user_books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('user_books', 'lib_books.id', '=', 'user_books.book_id')
            ->select('lib_books.*', 'genres.name as genre', 'authors.name as author', 'user_books.user_id as user')
            ->where('user_books.user_id', Auth::user()->id)
            ->get();

        $user_orders = DB::table('orders')
            ->join('lib_books', 'lib_books.id', '=', 'orders.book_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('users', 'users.id', '=', 'orders.giving_id')
            ->select('lib_books.name as book', 'authors.name as author', 'users.name as owner', 'orders.*')
            ->where('orders.taker_id', Auth::user()->id)
            ->where('orders.return', 0)
            ->get();

        return view('profile', array('user_info' => Auth::user(), 'user_books' => $user_books, 'user_orders' => $user_orders));
    }

    public function update_user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update($request->all());

        return redirect('profile');
    }

    public function delete_user()
    {
        return array('user_info' => Auth::user());
    }

    public function set_password(Request $request)
    {
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->password, $hashedPassword) and $request->new_password == $request->password_confirmation) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            return redirect('profile');
        }
        return 'Error';
    }
}
