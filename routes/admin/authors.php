<?php

Route::prefix('admin')->group(function () {

    Route::get('/authors', 'AdminAuthorsController@adminAuthors');

    Route::post('edit_author', 'AdminAuthorsController@adminAuthorUpdate');

    Route::post('admin_create_author', 'AdminAuthorsController@adminAuthorCreate');

    Route::post('admin_del_author/{author_id}', 'AdminAuthorsController@adminAuthorDelete');
});