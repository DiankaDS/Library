<?php
Route::prefix('admin')->group(function () {

    Route::get('/recommended', 'AdminUserBooksController@adminRecommendations');

    Route::post('/admin_approve', 'AdminUserBooksController@acceptRecommendation');

    Route::post('/admin_not_approve', 'AdminUserBooksController@deleteRecommendation');

    Route::post('/edit_price', 'AdminUserBooksController@adminRecommendationUpdatePrice');

    Route::post('/edit_link', 'AdminUserBooksController@adminRecommendationUpdateLink');
});
