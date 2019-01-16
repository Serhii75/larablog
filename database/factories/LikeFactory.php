<?php

use Faker\Generator as Faker;

$factory->define(App\Like::class, function (Faker $faker) {
    return [
        'user_id' => App\User::inRandomOrder()->first()->id,
    ];
});
