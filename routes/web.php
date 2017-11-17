<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

// Home routes

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Profile routes

Route::get('profile', 'ProfileController@user_profile');

Route::get('/update_user', function () { return view('update_user'); });
Route::post('/update_user/complete', 'ProfileController@update_user');

Route::get('/set_password', function () { return view('set_password'); });
Route::post('/set_password/complete', 'ProfileController@set_password');

Route::get('/delete_user','ProfileController@delete_user');

Route::post('/upload_photo','ProfileController@upload_photo');

// Books routes

Route::get('add_book', 'BooksController@add_book_form');

Route::post('add_book/complete', 'BooksController@create');

Route::delete('delete/{book_id}','BooksController@delete');

Route::get('book_{book_id}', 'BooksController@book_details');

Route::post('/add_review','BooksController@add_review');

// Orders routes

Route::post('orders','OrdersController@create_order');

Route::get('orders/{book_id}', 'OrdersController@create_order');

Route::post('accept_order','OrdersController@accept_order');

Route::post('delete_order','OrdersController@delete_order');

Route::get('orders_to_user','OrdersController@orders_to_user');

Route::get('orders_from_user','OrdersController@orders_from_user');

Route::post('book_return','OrdersController@book_return');

// Admin routes

//Route::get('/admin', 'AdminController@index');

Route::get('/admin_users', 'AdminController@admin_users');

Route::get('/admin_books', 'AdminController@admin_books');

Route::get('/admin_authors', 'AdminController@admin_authors');

Route::get('/admin_genres', 'AdminController@admin_genres');

Route::get('/admin_orders', 'AdminController@admin_orders');

Route::get('/admin_reviews', 'AdminController@admin_reviews');