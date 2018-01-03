<?php

Route::get('/admin_formats', 'AdminFormatsController@adminFormats');

Route::post('admin_del_format/{format_id}', 'AdminFormatsController@adminFormatDelete');

Route::post('admin_create_format', 'AdminFormatsController@adminFormatCreate');

Route::post('edit_format', 'AdminFormatsController@adminFormatUpdate');

// Add formats routes

Route::get('/all_formats', 'AddFormatsToUserBookController@allFormatsList');

Route::post('/add_formats', 'AddFormatsToUserBookController@addFormatsToBook');
