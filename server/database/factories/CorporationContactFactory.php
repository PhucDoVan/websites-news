<?php

/** @var Factory $factory */

use App\Http\Models\Corporation;
use App\Http\Models\CorporationContact;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(CorporationContact::class, function (Faker $faker) {
    return [
        'corporation_id' => factory(Corporation::class),
        'name'           => $faker->company,
        'tel'            => $faker->phoneNumber,
        'email'          => $faker->companyEmail,
        'fax'            => $faker->phoneNumber,
    ];
});
