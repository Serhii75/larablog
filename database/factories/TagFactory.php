<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->word,
        'slug' => str_slug($name),
    ];
});
