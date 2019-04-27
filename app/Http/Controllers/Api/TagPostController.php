<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use App\Tag;
use App\Http\Resources\PostCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index(Tag $tag)
    {
        $posts = $tag->posts()->with([
            'category', 'tags', 'user'
        ])->latest()->paginate(config('larablog.per_page.posts'));

        return new PostCollection($posts);
    }
}
