<?php

namespace App\Observers;

use App\Notifications\PostPublished;
use App\Post;

class PostObserver
{
    /**
     * Handle the post "creating" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $post->slug = str_slug($post->title) . '-' . date_timestamp_get(date_create());
        $post->live = request()->live ? true : false;
    }

    /**
     * Handle the post "updating" event.
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        $temp = explode('-', $post->slug);
        $post->slug = str_slug($post->title) . '-' . array_pop($temp);
        $post->live = request()->live ? true : false;

        if (request()->live) {
            $post->user->notify(new PostPublished($post));
        }
    }
}
