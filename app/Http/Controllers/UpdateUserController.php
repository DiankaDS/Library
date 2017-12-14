<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;

class UpdateUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
