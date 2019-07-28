<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Progress::class, function (Faker $faker) {
    return [
        'owner_id' => factory(App\User::class),
        'task_id' => factory(App\Task::class),
        'completed' => false
    ];
});
