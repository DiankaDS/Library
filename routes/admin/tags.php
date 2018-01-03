<?php

Route::get('/admin_tags', 'AdminTagsController@adminTags');

Route::post('admin_del_tag/{tag_id}', 'AdminTagsController@adminTagDelete');

Route::post('admin_create_tag', 'AdminTagsController@adminTagCreate');

Route::post('edit_tag', 'AdminTagsController@adminTagUpdate');

//  Add tags routes

Route::get('/all_tags', 'AddTagsToBookController@allTagsList');

Route::post('/add_tags', 'AddTagsToBookController@addTagsToBook');
