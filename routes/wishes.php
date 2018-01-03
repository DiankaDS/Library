<?php

Route::get('/wishes', 'WishesController@wishes');

Route::post('/add_vote', 'WishesController@addVote');

Route::post('/delete_vote', 'WishesController@deleteVote');
