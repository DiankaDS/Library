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

Route::post('search_books','HomeController@searchBooks');

// Wishes routes

Route::get('/wishes', 'WishesController@wishes');

Route::post('/add_vote', 'WishesController@addVote');

Route::post('/delete_vote', 'WishesController@deleteVote');

// Profile routes

Route::get('profile/{user_id}', 'ProfileController@userProfile');

Route::get('/update_user', 'ProfileController@viewUpdateUser');
Route::post('/update_user/complete', 'ProfileController@updateUser');

Route::get('/set_password', 'ProfileController@viewSetPassword');
Route::post('/set_password/complete', 'ProfileController@setPassword');

Route::post('/delete_user','ProfileController@deleteUser');

Route::post('/upload_photo','ProfileController@uploadPhoto');

// Books routes

Route::get('add_book', 'BooksController@addBookForm');

Route::post('add_book/complete', 'BooksController@create');

Route::delete('delete/{book_id}','BooksController@delete');

Route::get('book_{book_id}', 'BooksController@bookDetails');

Route::post('/add_review','BooksController@addReview');

Route::post('search_value','BooksController@addBookSearch');

// Google Books Api routes

Route::post('google_search','GoogleBooksController@googleBookSearch');

// Orders routes

Route::post('orders','OrdersController@createOrder');

Route::get('orders/{book_id}', 'OrdersController@createOrder');

Route::post('accept_order','OrdersController@acceptOrder');

Route::post('delete_order','OrdersController@deleteOrder');

Route::get('orders_to_user','OrdersController@ordersToUser');

Route::get('orders_from_user','OrdersController@ordersFromUser');

Route::post('book_return','OrdersController@bookReturn');

// Admin routes

Route::get('admin', function () {
    return redirect('/admin_users');
});

Route::get('/admin_users', 'AdminController@adminUsers');

Route::get('/admin_books', 'AdminController@adminBooks');

Route::get('/admin_authors', 'AdminController@adminAuthors');

Route::get('/admin_genres', 'AdminController@adminGenres');

Route::get('/admin_orders', 'AdminController@adminOrders');

Route::get('/admin_reviews', 'AdminController@adminReviews');

Route::get('/admin_tags', 'AdminController@adminTags');

Route::post('admin_del_book/{book_id}', 'AdminController@adminBookDelete');

Route::post('admin_del_author/{author_id}', 'AdminController@adminAuthorDelete');

Route::post('admin_create_author', 'AdminController@adminAuthorCreate');

Route::post('admin_del_genre/{genre_id}', 'AdminController@adminGenreDelete');

Route::post('admin_create_genre', 'AdminController@adminGenreCreate');

Route::post('admin_del_review/{review_id}', 'AdminController@adminReviewDelete');

Route::post('admin_del_tag/{tag_id}', 'AdminController@adminTagDelete');

Route::post('admin_create_tag', 'AdminController@adminTagCreate');

Route::post('add_to_admin', 'AdminController@addToAdmin');

Route::post('delete_from_admin', 'AdminController@deleteFromAdmin');

Route::post('add_tags', 'AdminController@addTagsToBook');

// Register with Facebook routes

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');