<?php

Route::prefix('admin')->group(function () {

    Route::get('/genres', 'AdminGenresController@adminGenres');

    Route::post('admin_del_genre/{genre_id}', 'AdminGenresController@adminGenreDelete');

    Route::post('admin_create_genre', 'AdminGenresController@adminGenreCreate');

    Route::post('edit_genre', 'AdminGenresController@adminGenreUpdate');
});
