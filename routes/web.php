<?php

use App\category;
use App\Http\Resources\Category as CategoryResource;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $category = Category::find(3);

    $result = (new CategoryResource($category))->filtrate('hide', ['posts', 'slug', 'updated_at']);

    dump($result);

    return view('welcome');
});
