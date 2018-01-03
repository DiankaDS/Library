<?php

Route::post('orders','OrdersController@createOrder');

Route::get('orders/{book_id}', 'OrdersController@createOrder');

Route::post('accept_order','OrdersController@acceptOrder');

Route::post('delete_order','OrdersController@deleteOrder');

Route::get('orders_to_user','OrdersController@ordersToUser');

Route::get('orders_from_user','OrdersController@ordersFromUser');

Route::post('book_return','OrdersController@bookReturn');

Route::post('edit_date','OrdersController@editDate');
