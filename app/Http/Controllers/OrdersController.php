<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\User;
use Mail;
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

        $giving_user = User::find($request->get('giving_id'))->toArray();

        Mail::send('emails.mailExample', $giving_user, function($message) use ($giving_user){
//            $message->getHeaders()
//                ->addTextHeader('PROJECT', 'Library');
//            $message->getHeaders()
//                ->addTextHeader('EMAILS', 'diana.agafonova@nixsolutions.com');
            $message->from('library.mailer@nixsolutions.com');
            $message->to($giving_user['email'])->subject('New order');
        });

        $message = "Order created!";

        return redirect('home')->with('status', $message);
    }

    protected function accept_order(Request $request){
        $order = Order::find($request->get('order_id'));

        $order->accept = 1;
        $order->save();

        $message = "Order accepted!";

        return redirect('orders_to_user')->with('status', $message);
    }

    protected function delete_order(Request $request){
        $order = Order::find($request->get('order_id'));
        $order->delete();

        $message = "Order deleted!";

        return back()->with('status', $message);
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

        $orders_to_user_accept = $orders_to_user->where('accept', 1);
        $orders_to_user_not_accept = $orders_to_user->where('accept', 0);

        $confirm_return_form_message = 'Are you sure that the user returned this book?';

        return view('orders_to_user', array(
//            'orders_to_user' => $orders_to_user,
            'orders_to_user_accept' => $orders_to_user_accept,
            'orders_to_user_not_accept' => $orders_to_user_not_accept,
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

        $orders_from_user_accept = $orders_from_user->where('accept', 1);
        $orders_from_user_not_accept = $orders_from_user->where('accept', 0);

        return view('orders_from_user', array(
//            'orders_from_user' => $orders_from_user,
            'orders_from_user_accept' => $orders_from_user_accept,
            'orders_from_user_not_accept' => $orders_from_user_not_accept,
        ));
    }

    protected function book_return(Request $request){
        $order = Order::find($request->get('order_id'));

        $order->return = 1;
        $order->save();

        $message = "Book returned!";

        return redirect('orders_to_user')->with('status', $message);
    }

}
