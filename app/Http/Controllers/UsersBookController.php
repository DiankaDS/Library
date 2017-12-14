<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\LibBook;

class UsersBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function deleteBook(Request $request){

        $user = User::find(Auth::user()->id);
        $user->books()->detach($request->get('id'));

        $message = "Book deleted!";
        return back()->with('status', $message);
    }

    protected function addBookUser(Request $request)
    {
        $book = LibBook::where('id', $request->get('book_id'))->first();
        $user = User::find(Auth::user()->id);
        $book->users()->save($user);

        $message = "You added to owners!";

        return back()->with('status', $message);
    }
}
