<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::post('/register', 'Auth\RegisterController@register');

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('/{category}', 'CategoryController@show');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'CategoryController@store');
            Route::patch('/{category}', 'CategoryController@update');
            Route::delete('/{category}', 'CategoryController@destroy');
        });
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', 'PostController@index');
        Route::get('/{post}', 'PostController@show');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'PostController@store');
            Route::post('/{post}/restore', 'PostController@restore');
            Route::patch('/{post}', 'PostController@update');
            Route::delete('/{post}', 'PostController@destroy');
            Route::delete('/{post}/delete', 'PostController@forceDelete');
        });
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', 'TagController@index');
        Route::get('/{tag}', 'TagController@show');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'TagController@store');
            Route::patch('/{tag}', 'TagController@update');
            Route::delete('/{tag}', 'TagController@destroy');
        });
    });
});
