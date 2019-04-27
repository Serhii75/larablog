<?php

/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpUnhandledExceptionInspection */

namespace App\Http\Controllers\Api;

use App\{Comment, Post};
use App\Http\Controllers\Controller;
use App\Http\Resources\{
    Comment as CommentResource,
    CommentCollection
};
use App\Traits\Controllers\ItemsTree;
use App\Http\Requests\Api\Comment\{
    StoreCommentRequest,
    UpdateCommentRequest
};
use App\Notifications\PostCommented;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    use ItemsTree;

    /**
     * Display a listing of the resource.
     *
     * @return CommentCollection
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user', 'parent.user')->get();

        $nested = $this->buildTree($comments);

        return new CommentCollection($nested->paginate(config('larablog.per_page.comments')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCommentRequest  $request
     * @return CommentResource
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create(array_merge(
            $request->only('parent_id', 'body'),
            ['user_id' => $request->user()->id]
        ));

        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCommentRequest $request
     * @param  Post $post
     * @param  Comment $comment
     *
     * @return CommentResource
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->update($request->only('parent_id', 'body'));

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @param  Comment  $comment
     * @return Response
     */
    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response(null, 204);
    }
}
