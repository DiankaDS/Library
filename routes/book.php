<?php

// Create book routes

Route::get('add_book', 'CreateBookController@addBookForm');

Route::post('add_book/complete', 'CreateBookController@createBook');

Route::post('search_value','SearchController@addBookSearch');

// Books routes

Route::post('add_book_user', 'UsersBookController@addBookUser');

Route::delete('delete/{book_id}','UsersBookController@deleteBook');

Route::get('book_{book_id}', 'BookDetailsController@bookDetails');

// Update book routes

Route::get('/update_book/{book_id}', 'UpdateBookController@viewUpdateBook');

Route::post('/update_book/complete', 'UpdateBookController@updateBook');