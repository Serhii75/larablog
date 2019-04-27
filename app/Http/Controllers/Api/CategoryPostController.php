<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Resources\PostCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(Category $category)
    {
        if ($category) {
            dump('Something');
        }

        $posts = $category->posts()->with([
            'category',
            'tags',
            'user'
        ])->latest()->paginate(config('larablog.per_page.posts'));

        return new PostCollection($posts);
    }
}
