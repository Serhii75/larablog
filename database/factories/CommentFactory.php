<?php

use App\{Comment, Post, User};
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        // 'post_id' => Post::inRandomOrder()->first()->id,
        'body' => $faker->sentences(rand(1, 5), true),
    ];
});
