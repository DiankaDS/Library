<?php

Route::prefix('admin')->group(function () {

    Route::get('/users', 'AdminUsersController@adminUsers');

    Route::post('add_to_admin', 'AdminUsersController@addToAdmin');

Route::post('delete_from_admin', 'AdminUsersController@deleteFromAdmin');
});
