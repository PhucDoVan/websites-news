<?php

/** @var Factory $factory */

use App\Http\Models\Permission;
use App\Http\Models\Service;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'service_id' => factory(Service::class),
        'label'      => $faker->sentence(4),
        'name'       => $faker->userName,
    ];
});
