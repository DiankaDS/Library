<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function create_order(Request $request)
    {
        $request->validate([
            'date_start' => 'required|date',
            'date_end' => 'required|date',
        ]);

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
        $order = Order::find($request->get('order_id'));

        $order->accept = 1;
        $order->save();

        return redirect('orders_to_user');
    }

    protected function delete_order(Request $request){
        $order = Order::find($request->get('order_id'));
        $order->delete();

        return redirect('orders_to_user');
    }

    protected function orders_to_user()
    {
        $orders_to_user = DB::table('orders')
            ->join('users', 'users.id', '=', 'orders.taker_id')
            ->join('lib_books', 'orders.book_id', '=', 'lib_books.id')
            ->select('orders.*', 'users.*', 'lib_books.name as book', 'orders.id as order_id')
            ->where([
                ['orders.giving_id', Auth::user()->id],
                ['orders.return', 0],
                ])
            ->get();

        $confirm_return_form_message = 'Are you sure that the user returned this book?';

        return view('orders_to_user', array(
            'orders_to_user' => $orders_to_user,
            'confirm_return_form_message' => $confirm_return_form_message,
        ));
    }

    protected function orders_from_user()
    {
        $orders_from_user = DB::table('orders')
            ->join('lib_books', 'lib_books.id', '=', 'orders.book_id')
//            ->join('authors_books', 'authors_books.book_id', '=', 'lib_books.id')
//            ->join('authors', 'authors.id', '=', 'authors_books.author_id')
            ->join('users', 'users.id', '=', 'orders.giving_id')
            ->select('lib_books.name as book', 'users.*', 'orders.*')
            ->where([
                ['orders.taker_id', Auth::user()->id],
                ['orders.return', 0],
            ])
            ->get();

        return view('orders_from_user', array(
            'orders_from_user' => $orders_from_user
        ));
    }

    protected function book_return(Request $request){
        $order = Order::find($request->get('order_id'));

        $order->return = 1;
        $order->save();

        return redirect('orders_to_user');
    }

}
