<?php

Route::get('profile/{user_id}', 'ProfileController@userProfile');

Route::get('/update_user', 'UpdateUserController@viewUpdateUser');
Route::post('/update_user/complete', 'UpdateUserController@updateUser');

Route::get('/set_password', 'UpdateUserController@viewSetPassword');
Route::post('/set_password/complete', 'UpdateUserController@setPassword');

Route::post('/delete_user','DeleteUserController@deleteUser');

Route::post('/upload_photo','UpdateUserController@uploadPhoto');
