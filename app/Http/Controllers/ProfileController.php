<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $confirm_delete_book_message = 'Are you sure to delete book?';
        $confirm_delete_profile_message = 'Are you sure to delete profile?';

//        $user_orders = DB::table('orders')
//            ->join('lib_books', 'lib_books.id', '=', 'orders.book_id')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
//            ->join('users', 'users.id', '=', 'orders.giving_id')
//            ->select('lib_books.name as book', 'authors.name as author', 'users.name as owner', 'orders.*')
//            ->where('orders.taker_id', Auth::user()->id)
//            ->where('orders.return', 0)
//            ->get();

        return view('profile', array(
            'user_info' => Auth::user(),
            'user_books' => $user_books,
            'confirm_delete_book_message' => $confirm_delete_book_message,
            'confirm_delete_profile_message' => $confirm_delete_profile_message,
        ));
    }

    public function update_user(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if($user['username'] !== $request['username']){
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
            ]);
        }

        if($user['email'] !== $request['email']){
            $request->validate([
                'email' => 'required|string|email|max:255|unique:users',
            ]);
        }

        $request->validate([
//            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|integer',
        ]);

//        $user = User::find(Auth::user()->id);
        $user->update($request->all());

        $message = "You profile updated!";

        return redirect('profile')->with('status', $message);
    }

    public function upload_photo(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $file = $request->file('photo');
        $file_name = time().'_'.$_FILES['photo']['name'];
        $file->move(public_path().'/images/users', $file_name);

        $user = User::find(Auth::user()->id);
        $user->fill([
            'photo' => $file_name,
        ])->save();

        $message = "Photo was upload!";

        return redirect('profile')->with('status', $message);
    }

    public function delete_user()
    {
        $user = User::find(Auth::user()->id);
        $user->books()->detach();
        //user_orders_delete
        $user->delete();

        $message = "You profile deleted!";

        return redirect('home')->with('status', $message);
    }

    public function set_password(Request $request)
    {
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        if (!Hash::check($request->password, $hashedPassword)) {

            $message = "You password failed!";
            return back()->with('status', $message);
        }

        elseif ($request->new_password !== $request->password_confirmation){

            $message = "Confirmation failed!";
            return back()->with('status', $message);
        }
        else{
            $request->validate([
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $message = "You password changed!";
            return redirect('profile')->with('status', $message);
        }

    }
}
