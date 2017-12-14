<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminUsers()
    {
        $users = User::simplePaginate(12);
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

    protected function addToAdmin(Request $request)
    {
        $order = User::find($request->get('admins_user_id'));
        $order->role_id = 1;
        $order->save();

        $message = "User added to admin!";
        return back()->with('status', $message);
    }

    protected function deleteFromAdmin(Request $request)
    {
        $order = User::find($request->get('admins_user_id'));
        $order->role_id = 0;
        $order->save();

        $message = "User deleted from admin!";
        return back()->with('status', $message);
    }
}
