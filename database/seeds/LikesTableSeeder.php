<?php

use Illuminate\Database\Seeder;
use App\{Like, Post};

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::get()->each(function (Post $post) {
            $post->likes()->saveMany(factory(Like::class, rand(1, 10))->make());
        });
    }
}
