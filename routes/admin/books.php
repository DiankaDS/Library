<?php

Route::prefix('admin')->group(function () {

    Route::get('/books', 'AdminBooksController@adminBooks');

    Route::post('admin_del_book/{book_id}', 'AdminBooksController@adminBookDelete');
});