<?php

/** @var Factory $factory */

use App\Http\Models\Role;
use App\Http\Models\Service;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'service_id' => factory(Service::class),
        'label'      => $faker->sentence(4),
        'name'       => $faker->unique()->userName,
    ];
});
