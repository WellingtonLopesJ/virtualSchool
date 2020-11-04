<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'date' => $faker->dateTimeBetween(date('Y-m-d H:i:s'), '+7 days')
    ];
});
