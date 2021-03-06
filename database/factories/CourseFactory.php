<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Domain\Course\Models\Course;

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle . ' ' . Str::random(5)
    ];
});
