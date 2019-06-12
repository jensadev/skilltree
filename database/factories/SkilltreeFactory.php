<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Skilltree;
use Faker\Generator as Faker;

$factory->define(Skilltree::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'owner_id' => factory(App\User::class)
    ];
});
