<?php

Route::get('/admin_books', 'AdminBooksController@adminBooks');

Route::post('admin_del_book/{book_id}', 'AdminBooksController@adminBookDelete');
