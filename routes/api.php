<?php

use Illuminate\Support\Facades\Route;

// Laravel already adds the "/api" prefix for you here!
Route::group([
    "prefix" => "auth" 
], function () {
    Route::post ('/login', function () {
    });
});