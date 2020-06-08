<?php

/** @var Factory $factory */

use App\Http\Models\Manager;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Manager::class, function (Faker $faker) {
    return [
        'name'       => $faker->name,
        'username'   => $faker->unique()->userName,
        'password'   => bcrypt('admin'),
        'deleted_at' => null,
    ];
});
