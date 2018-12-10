<?php

use App\{Post, Tag};
use Illuminate\Database\Seeder;

class PostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = Post::get();

        foreach ($posts as $post) {
            $tags = Tag::inRandomOrder()->limit(rand(1, 3))->pluck('id')->toArray();
            $post->tags()->sync($tags);
        }
    }
}
