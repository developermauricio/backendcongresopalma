<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Point;
use Faker\Generator as Faker;

$factory->define(Point::class, function (Faker $faker) {
    return [
        'user_id' => \App\User::all()->random()->id,
    ];
});
