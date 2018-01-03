<?php

Route::get('/admin_authors', 'AdminAuthorsController@adminAuthors');

Route::post('admin_del_author/{author_id}', 'AdminAuthorsController@adminAuthorDelete');

Route::post('admin_create_author', 'AdminAuthorsController@adminAuthorCreate');

Route::post('edit_author', 'AdminAuthorsController@adminAuthorUpdate');
