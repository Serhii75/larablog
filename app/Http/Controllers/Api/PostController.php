<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\{Post};
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new PostCollection(Post::with('tags')->paginate(32));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\Post\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create(array_merge(
            $request->only('category_id', 'title', 'image', 'body'),
            ['user_id' => $request->user()->id]
        ));

        if ($request->tags) {
            $tags = Tag::saveManyFromString($request->tags);
            $post->tags()->attach($tags->pluck('id')->toArray());
        }

        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\Post\UpdatePostRequest  $request
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->only('category_id', 'title', 'image', 'body'));

        if ($request->tags) {
            $tags = Tag::saveManyFromString($request->tags);
            $post->tags()->sync($tags->pluck('id')->toArray());
        }

        $post->load('category', 'tags', 'user');

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
