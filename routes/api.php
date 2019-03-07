<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['json'])->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::resource('items', 'ItemController')
            ->only('index', 'show', 'store', 'destroy', 'update');
        Route::get('users/me', 'UserController@me');
    });
    Route::post('auth/signin', 'AuthController@signin');
    Route::post('auth/signup', 'AuthController@signup');
});


