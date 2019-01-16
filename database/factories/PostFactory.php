<?php

use App\{Category, Post, User};
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    $sentence = $faker->unique()->sentence(rand(2, 4), true);
    $title = substr($sentence, 0, strlen($sentence) - 1);

    return [
        'user_id' => User::inRandomOrder()->first()->id,
        'category_id' => Category::inRandomOrder()->first()->id,
        'title' => $title,
        'slug' => str_slug($title),
        'image' => asset('storage/images') . '/' . rand(1, 20) . '.jpg',
        'body' => $faker->paragraphs(rand(5, 10), true),
        'live' => 1,
    ];
});
