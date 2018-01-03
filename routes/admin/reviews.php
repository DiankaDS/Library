<?php

Route::get('/admin_reviews', 'AdminReviewsController@adminReviews');

Route::post('admin_del_review/{review_id}', 'AdminReviewsController@adminReviewDelete');
