<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrdersController extends Controller
{
    protected function create_order(Request $request)
    {
        $order =
            Order::create([
                'giving_id' => $request->get('name'),
                'taker_id' => $request->get('year'),
                'date_start' => $request->get('author'),
                'date_end' => '1',
                'book_id' => '1',
            ]);

        return [$order];
    }
}
