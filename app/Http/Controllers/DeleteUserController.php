<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;

class DeleteUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
}
