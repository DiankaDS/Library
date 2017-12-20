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

//Route::get('/', 'HomeController@index')->name('home');
//Route::get('/home', 'HomeController@index')->name('home');

//Route::post('search_books','SearchController@searchBooks');

Route::get('/', 'HomeController@homeSearch')->name('home');
Route::get('/home', 'HomeController@homeSearch')->name('home');

Route::post('/home_search_books', 'HomeController@homeSearchBooks');


//Route::get('/home_search', 'HomeController@homeSearch');
//
//Route::post('/home_search_books', 'HomeController@homeSearchBooks');

// Wishes routes

Route::get('/wishes', 'WishesController@wishes');

Route::post('/add_vote', 'WishesController@addVote');

Route::post('/delete_vote', 'WishesController@deleteVote');

// Profile routes

Route::get('profile/{user_id}', 'ProfileController@userProfile');

Route::get('/update_user', 'UpdateUserController@viewUpdateUser');
Route::post('/update_user/complete', 'UpdateUserController@updateUser');

Route::get('/set_password', 'UpdateUserController@viewSetPassword');
Route::post('/set_password/complete', 'UpdateUserController@setPassword');

Route::post('/delete_user','DeleteUserController@deleteUser');

Route::post('/upload_photo','UpdateUserController@uploadPhoto');

// Create book routes

Route::get('add_book', 'CreateBookController@addBookForm');

Route::post('add_book/complete', 'CreateBookController@createBook');

Route::post('search_value','SearchController@addBookSearch');

// Books routes

Route::post('add_book_user', 'UsersBookController@addBookUser');

Route::delete('delete/{book_id}','UsersBookController@deleteBook');

Route::get('book_{book_id}', 'BookDetailsController@bookDetails');

Route::post('/add_review','ReviewController@addReview');

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

// Admin users routes

Route::get('/admin_users', 'AdminUsersController@adminUsers');

Route::post('add_to_admin', 'AdminUsersController@addToAdmin');

Route::post('delete_from_admin', 'AdminUsersController@deleteFromAdmin');

// Admin books routes

Route::get('/admin_books', 'AdminBooksController@adminBooks');

Route::post('admin_del_book/{book_id}', 'AdminBooksController@adminBookDelete');

// Admin authors routes

Route::get('/admin_authors', 'AdminAuthorsController@adminAuthors');

Route::post('admin_del_author/{author_id}', 'AdminAuthorsController@adminAuthorDelete');

Route::post('admin_create_author', 'AdminAuthorsController@adminAuthorCreate');

// Admin genres routes

Route::get('/admin_genres', 'AdminGenresController@adminGenres');

Route::post('admin_del_genre/{genre_id}', 'AdminGenresController@adminGenreDelete');

Route::post('admin_create_genre', 'AdminGenresController@adminGenreCreate');

// Admin orders routes

Route::get('/admin_orders', 'AdminOrdersController@adminOrders');

// Admin reviews routes

Route::get('/admin_reviews', 'AdminReviewsController@adminReviews');

Route::post('admin_del_review/{review_id}', 'AdminReviewsController@adminReviewDelete');

// Admin tags routes

Route::get('/admin_tags', 'AdminTagsController@adminTags');

Route::post('admin_del_tag/{tag_id}', 'AdminTagsController@adminTagDelete');

Route::post('admin_create_tag', 'AdminTagsController@adminTagCreate');

Route::post('add_tags', 'AdminTagsController@addTagsToBook');

// Register with Facebook routes

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');