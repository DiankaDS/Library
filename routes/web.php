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

Route::post('search_books','HomeController@search_books');

// Profile routes

Route::get('profile/{user_id}', 'ProfileController@user_profile');

Route::get('/update_user', 'ProfileController@view_update_user');
Route::post('/update_user/complete', 'ProfileController@update_user');

Route::get('/set_password', 'ProfileController@view_set_password');
Route::post('/set_password/complete', 'ProfileController@set_password');

Route::post('/delete_user','ProfileController@delete_user');

Route::post('/upload_photo','ProfileController@upload_photo');

// Books routes

Route::get('add_book', 'BooksController@add_book_form');

Route::post('add_book/complete', 'BooksController@create');

Route::delete('delete/{book_id}','BooksController@delete');

Route::get('book_{book_id}', 'BooksController@book_details');

Route::post('/add_review','BooksController@add_review');

Route::post('search_value','BooksController@add_book_search');

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

Route::get('admin', function () {
    return redirect('/admin_users');
});

Route::get('/admin_users', 'AdminController@admin_users');

Route::get('/admin_books', 'AdminController@admin_books');

Route::get('/admin_authors', 'AdminController@admin_authors');

Route::get('/admin_genres', 'AdminController@admin_genres');

Route::get('/admin_orders', 'AdminController@admin_orders');

Route::get('/admin_reviews', 'AdminController@admin_reviews');

Route::post('admin_del_book/{book_id}', 'AdminController@admin_book_delete');

Route::post('admin_del_author/{author_id}', 'AdminController@admin_author_delete');

Route::post('admin_create_author', 'AdminController@admin_author_create');

Route::post('admin_del_genre/{genre_id}', 'AdminController@admin_genre_delete');

Route::post('admin_create_genre', 'AdminController@admin_genre_create');

Route::post('admin_del_review/{review_id}', 'AdminController@admin_review_delete');

Route::post('add_to_admin', 'AdminController@add_to_admin');

Route::post('delete_from_admin', 'AdminController@delete_from_admin');

// Register with Facebook routes

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');