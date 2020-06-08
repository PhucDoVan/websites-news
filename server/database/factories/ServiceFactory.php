<?php

/** @var Factory $factory */

use App\Http\Models\Service;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'name'       => $faker->sentence(4),
        'token'      => $faker->unique()->uuid,
        'deleted_at' => null,
    ];
});
