<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    protected function create_order(Request $request)
    {
            Order::create([
                'giving_id' => $request->get('giving_id'),
                'taker_id' => Auth::user()->id,
                'date_start' => $request->get('date_start'),
                'date_end' => $request->get('date_end'),
                'book_id' => $request->get('book_id'),
            ]);

        return redirect('home');
    }

    protected function accept_order(Request $request){
        return $request;
    }

    protected function delete_order(Request $request){
        return $request;
    }

    protected function orders_to_user()
    {
        $orders_to_user = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.taker_id')
            ->join('lib_books', 'orders.book_id', '=', 'lib_books.id')
            ->select('orders.*', 'users.*', 'lib_books.name as book')
            ->where('orders.giving_id', Auth::user()->id)
            ->get();

        return view('orders_to_user', ['orders_to_user' => $orders_to_user]);
    }
}
