<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Skillgroup::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'skilltree_id' => factory(App\Skilltree::class)
    ];
});
