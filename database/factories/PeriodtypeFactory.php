<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Periodtype;
use Faker\Generator as Faker;

$factory->define(Periodtype::class, function (Faker $faker) {
    return [
        'name' => 'PerType ' . $faker->name
    ];
});
