<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "api/auth",
    "namespace" => "App\Http\Controllers",
], function () {

    Route::get('/', "AuthenticationController@index");
    Route::post('/login', "AuthenticationController@login");

    # should be handled by frontend
    Route::post('/refreshAccessToken' , "AuthenticationController@refreshAccessToken");
    
    Route::group(['middleware' => 'jwt.auth.middleware'], function () {
        Route::post('/logout', "AuthenticationController@logout");
        Route::get('/me', "AuthenticationController@me");
    });
});