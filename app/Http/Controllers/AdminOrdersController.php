<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    protected function adminOrders()
    {
        $orders = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.taker_id')
            ->join('users as users1', 'users1.id', '=', 'orders.giving_id')
            ->join('lib_books', 'orders.book_id', '=', 'lib_books.id')
            ->select('orders.*', 'users.username as taker', 'users1.username as giving', 'lib_books.name as book', 'orders.id as order_id')
//            ->get();
            ->simplePaginate(12);

        $confirm_delete_order_message = 'Are you sure to delete this order?';
        return view('admin/admin_orders', array(
            'orders' => $orders,
            'confirm_delete_order_message' => $confirm_delete_order_message,
        ));
    }
}
