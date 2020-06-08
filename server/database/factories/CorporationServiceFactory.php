<?php

/** @var Factory $factory */

use App\Http\Models\Corporation;
use App\Http\Models\CorporationService;
use App\Http\Models\Service;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(CorporationService::class, function (Faker $faker) {
    return [
        'corporation_id' => factory(Corporation::class),
        'service_id'     => factory(Service::class),
        'status'         => $faker->randomElement([0, 1, 2]),
        'reason'         => $faker->sentence(),
        'terminated_at'  => null,
    ];
});
