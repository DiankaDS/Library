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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('profile', 'ProfileController@user_profile');

Route::get('add_book', 'BooksController@add_book_form');

Route::post('add_book/complete', 'BooksController@create');

Route::delete('delete/{book_id}','BooksController@delete');

Route::get('orders/{book_id}', 'OrdersController@create_order');

Route::get('book_{book_id}', 'HomeController@book_details');

Route::get('/update_user', function () { return view('update_user'); });
Route::post('/update_user/complete', 'ProfileController@update_user');

Route::get('/set_password', function () { return view('set_password'); });
Route::post('/set_password/complete', 'ProfileController@set_password');

Route::get('/delete_user','ProfileController@delete_user');

Route::post('/add_review','HomeController@add_review');