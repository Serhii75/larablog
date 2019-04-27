<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Post, Tag};
use App\Http\Requests\Api\Post\{
    StorePostRequest,
    UpdatePostRequest
};
use App\Http\Resources\{
    Post as PostResource,
    PostCollection
};

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PostCollection
     */
    public function index()
    {
        $posts = Post::previews()
            ->paginate(config('larablog.per_page.posts'));

        return (new PostCollection($posts))->except('body');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @return PostResource
     */
    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create(
            $request->only('category_id', 'title', 'image', 'body')
        );

        if ($request->tags) {
            $post->saveTagsFromString($request->tags);
        }

        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest  $request
     * @param  Post $post
     * @return PostResource
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        // $this->authorize('update', $post);

        $post->update($request->only('category_id', 'title', 'image', 'body'));

        if ($request->tags) {
            $post->saveTagsFromString($request->tags);
        }

        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response(null, 204);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  integer $id
     * @return PostResource
     */
    public function restore($id)
    {
        $post = Post::withTrashed()->find($id);

        $this->authorize('restore', $post);

        $post->restore();
        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Hard delete the specified resource from storage.
     *
     * @param  Post $post
     * @return Response
     */
    public function forceDelete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->tags()->sync([]);
        $post->forceDelete();

        return response(null, 204);
    }
}
