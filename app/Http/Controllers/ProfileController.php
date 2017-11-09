<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ProfileController extends Controller
{
    public function user_profile()
    {
        return view('profile', array('user_info' => Auth::user()));
    }
}
