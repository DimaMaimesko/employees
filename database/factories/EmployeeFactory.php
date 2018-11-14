<?php

use Faker\Generator as Faker;
use App\Models\Employee;


$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'position' => $faker->jobTitle,
        'hired_at' => $faker->dateTimeThisDecade,
    ];
});