<?php

// Register with Facebook routes

Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider');

Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');