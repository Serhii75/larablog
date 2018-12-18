<?php

use App\{Comment, Post};
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Post::get()->each(function (Post $post) {
            $comments = $post->comments()->saveMany(factory(Comment::class, 3)->make());

            $comments->each(function ($comment) use ($post) {
                $comment->replies()->saveMany($this->createComments($comment, $post, 3));
            });
        });
    }

    protected function createComments($comment, $post, $depth = 2, $currentDepth = 0)
    {
        if ($currentDepth == $depth) {
            return [];
        }

        $comments = $post->comments()->saveMany(factory(Comment::class, 3)->make());

        $comments->each(function ($reply) use ($post, $depth, $currentDepth) {
            $reply->replies()->saveMany($this->createComments($reply, $post, $depth, ++$currentDepth));
        });

        return $comments;
    }
}
