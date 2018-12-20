<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Resources\{
    CommentCollection,
    PostCollection,
    User as UserResource,
    UserCollection
};
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(config('larablog.per_page.users'));

        return new UserCollection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\User\UpdateUserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->only('name', 'email'));

        return new UserResource($user);
    }

    /**
     * Display a listing of the user posts.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function posts(User $user)
    {
        $posts = $user->posts()->with([
            'category', 'tags', 'user'
        ])->latest()->paginate(config('larablog.per_page.posts'));

        return new PostCollection($posts);
    }

    /**
     * Display a listing of the user comments.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function comments(User $user)
    {
        $comments = $user->comments()->latest()->with(
            'user', 'parent.user'
        )->paginate(config('larablog.per_page.comments'));

        return new CommentCollection($comments);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $tag->delete();

        return response(null, 204);
    }
}
