<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userProfile($http_response_header)
    {
        $user_id = $http_response_header;

        $user_books = DB::table('lib_books')
            ->join('genres', 'genres.id', '=', 'lib_books.genre_id')
            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('user_books', 'lib_books.id', '=', 'user_books.book_id')
            ->select('lib_books.*', 'genres.name as genre', 'user_books.user_id as user', DB::raw('group_concat(authors.name) as author'))
            ->where('user_books.user_id', $user_id)
            ->groupBy('lib_books.id', 'genres.name', 'user_books.user_id')
//            ->get();
            ->simplePaginate(6);

        $confirm_delete_book_message = 'Are you sure to delete book?';
        $confirm_delete_profile_message = 'Are you sure to delete profile?';

        return view('profile', array(
            'user_info' => User::find($user_id),
            'user_books' => $user_books,
            'confirm_delete_book_message' => $confirm_delete_book_message,
            'confirm_delete_profile_message' => $confirm_delete_profile_message,
        ));
    }

    public function viewUpdateUser()
    {
        return view('update_user');
    }

    public function updateUser(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user['username'] !== $request['username']) {
            $request->validate([
                'username' => 'required|string|max:255|unique:users',
            ]);
        }

        if ($user['email'] !== $request['email']) {
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

        $user->update($request->all());

        $message = "Your profile updated!";

        return back()->with('status', $message);
    }

    public function uploadPhoto(Request $request)
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

        return back()->with('status', $message);
    }

    public function deleteUser(Request $request)
    {
        if ($request->get('admins_user_id')) {
            $user_id = $request->get('admins_user_id');
            $user_hello = "User";
        }
        else {
            $user_id = Auth::user()->id;
            $user_hello = "You";
        }

        $orders_from_user = DB::table('orders')
            ->select('orders.id')
            ->where([
                ['orders.taker_id', $user_id],
                ['orders.return', 0],
                ['orders.accept', 1],
            ])
            ->get();

        $orders_to_user = DB::table('orders')
            ->select('orders.id')
            ->where([
                ['orders.giving_id', $user_id],
                ['orders.return', 0],
                ['orders.accept', 1],
            ])
            ->get();

        if (count($orders_from_user) != 0) {
            $message = "{$user_hello} have taken books. Please, return their first.";

            return back()->with('status', $message);
        }
        elseif (count($orders_to_user) != 0) {
            $message = "{$user_hello} give books. Please, regain their first.";

            return back()->with('status', $message);
        }
        else {
            Order::where('taker_id', $user_id)
                ->orWhere('giving_id', $user_id)
                ->delete();

            $user = User::find($user_id);
            $user->books()->detach();

            $user->delete();

            $message = "Profile deleted!";
        }

        return back()->with('status', $message);
    }

    public function viewSetPassword()
    {
        return view('set_password');
    }

    public function setPassword(Request $request)
    {
        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);

        if (!Hash::check($request->password, $hashedPassword)) {

            $message = "Your password failed!";
            return back()->with('status', $message);
        }

        elseif ($request->new_password !== $request->password_confirmation){

            $message = "Confirmation failed!";
            return back()->with('status', $message);
        }
        else {
            $request->validate([
                'new_password' => 'required|string|min:6|confirmed',
            ]);

            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            $message = "Your password changed!";
            return back()->with('status', $message);
        }
    }
}
