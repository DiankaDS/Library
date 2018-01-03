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

Route::get('/', 'HomeController@homeSearch')->name('home');
Route::get('/home', 'HomeController@homeSearch')->name('home');

Route::post('/home_search_books', 'HomeController@homeSearchBooks');
