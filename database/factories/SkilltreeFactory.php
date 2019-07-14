<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Skilltree::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'owner_id' => factory(App\User::class)
    ];
});
