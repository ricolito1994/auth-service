<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => "api/auth",
    "namespace" => "App\Http\Controllers",
], function () {

    Route::get('/', "AuthenticationController@index");
    Route::post('/login', "AuthenticationController@login");
    
    Route::group(['middleware' => 'jwt.auth.middleware'], function () {
        Route::post('/refreshtoken' , "AuthenticationController@refreshToken");
    });
});