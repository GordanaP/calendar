<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BusinessDay;
use Faker\Generator as Faker;

$factory->define(BusinessDay::class, function (Faker $faker) {
    return [
        'open' => '09:00',
        'close' => '20:00',
    ];
});
