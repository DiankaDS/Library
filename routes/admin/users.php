<?php

Route::get('/admin_users', 'AdminUsersController@adminUsers');

Route::post('add_to_admin', 'AdminUsersController@addToAdmin');

Route::post('delete_from_admin', 'AdminUsersController@deleteFromAdmin');
