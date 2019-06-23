<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Skill::class, function (Faker $faker) {
    return [
        'skill_title' => $faker->word,
        'skilltree_id' => factory(App\Skilltree::class)
    ];
});
