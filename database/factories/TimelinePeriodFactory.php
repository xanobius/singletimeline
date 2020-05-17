<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TimelinePeriod;
use App\Timeline;
use App\Periodtype;
use Faker\Generator as Faker;

$factory->define(TimelinePeriod::class, function (Faker $faker) {
    return [
        'timeline_id' => factory(Timeline::class)->create()->id,
        'periodtype_id' => factory(Periodtype::class)->create()->id
    ];
});
