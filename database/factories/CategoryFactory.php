<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $name = $faker->unique()->name,
        'slug' => str_slug($name),
        'description' => rand(0, 1) ? $faker->paragraph(rand(1, 2), true) : null,
        'live' => 1,
    ];
});
