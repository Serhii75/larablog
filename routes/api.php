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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/logout', 'Auth\LogoutController')->middleware('auth:api');
    Route::get('/me', 'UserController@me')->middleware('auth:api');

    Route::prefix('categories')->group(function () {
        Route::get('/', 'CategoryController@index');
        Route::get('/{category}', 'CategoryController@show');
        Route::get('/{category}/posts', 'CategoryPostController@index');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'CategoryController@store');
            Route::patch('/{category}', 'CategoryController@update');
            Route::delete('/{category}', 'CategoryController@destroy');
        });
    });

    Route::prefix('posts')->group(function () {
        Route::get('/', 'PostController@index');
        Route::get('/{post}', 'PostController@show');
        Route::get('/{post}/comments', 'PostCommentController@index');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'PostController@store');
            Route::post('/{post}/restore', 'PostController@restore');
            Route::patch('/{post}', 'PostController@update');
            Route::delete('/{post}', 'PostController@destroy');
            Route::delete('/{post}/delete', 'PostController@forceDelete');

            Route::post('/{post}/comments', 'PostCommentController@store');
            Route::patch('/{post}/comments/{comment}', 'PostCommentController@update');
            Route::delete('/{post}/comments/{comment}', 'PostCommentController@destroy');

            Route::post('/{post}/likes', 'PostLikeController@store');
        });
    });

    Route::prefix('tags')->group(function () {
        Route::get('/', 'TagController@index');
        Route::get('/{tag}', 'TagController@show');
        Route::get('/{tag}/posts', 'TagPostController@index');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/', 'TagController@store');
            Route::patch('/{tag}', 'TagController@update');
            Route::delete('/{tag}', 'TagController@destroy');
        });
    });

    Route::prefix('users')->group(function () {
        Route::get('/', 'UserController@index');
        Route::get('/{user}', 'UserController@show');
        Route::get('/{user}/posts', 'UserController@posts');
        Route::get('/{user}/comments', 'UserController@comments');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::patch('/{user}', 'UserController@update');
            Route::delete('/{user}', 'UserController@destroy');

            Route::get('/{user}/followers', 'FollowUserController@followers');
            Route::get('/{user}/follows', 'FollowUserController@follows');
            Route::post('/{user}/follow', 'FollowUserController@follow');
            Route::delete('/{user}/unfollow', 'FollowUserController@unfollow');
        });
    });
});
