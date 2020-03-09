<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\Doctor;
use App\Patient;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'doctor_id' => Doctor::first(),
        'patient_id' => Patient::inRandomOrder()->first()->id,
        'start_at' => Carbon::tomorrow()->addDays(rand(1,5))->startOfHour()->addHours(rand(9,15))
    ];
});
