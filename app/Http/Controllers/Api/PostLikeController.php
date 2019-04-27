<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PostLiked;
use App\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $like = $post->likes()->create(['user_id' => auth()->id()]);

        $post->user->notify(new PostLiked($post, $like));

        return response()->json([
            'message' => 'You liked the post ' . $post->title
        ], 201);
    }
}
