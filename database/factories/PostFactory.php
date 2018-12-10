<?php

use App\{Category, Post, User};
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'category_id' => Category::inRandomOrder()->first()->id,
        'title' => $title = $faker->unique()->sentence(rand(1, 3), true),
        'slug' => str_slug($title),
        'body' => $faker->paragraphs(rand(5, 10), true),
        'live' => 1,
    ];
});
