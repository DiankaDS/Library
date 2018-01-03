<?php

Route::prefix('admin')->group(function () {

    Route::get('/reviews', 'AdminReviewsController@adminReviews');

    Route::post('admin_del_review/{review_id}', 'AdminReviewsController@adminReviewDelete');
});
