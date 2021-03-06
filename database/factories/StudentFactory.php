<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;
use Domain\Student\Models\Student;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surnames' => $faker->lastName . " " . $faker->cityPrefix,
    ];
});
