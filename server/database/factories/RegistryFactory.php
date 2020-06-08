<?php

/** @var Factory $factory */

use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\Group;
use App\Http\Models\Registry;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Registry::class, function (Faker $faker) {
    return [
        'corporation_id' => factory(Corporation::class),
        'group_id'       => factory(Group::class),
        'account_id'     => factory(Account::class),
        'label'          => $faker->sentence(),
        'v1_code'        => $faker->numerify('#############'),
        'number_type'    => $faker->randomElement([1, 2]),
        'number'         => $faker->buildingNumber,
        'pdf_type'       => $faker->randomElement([1, 2]),
        's3_object_url'  => $faker->url,
        'requested_at'   => $faker->dateTime,
        'based_at'       => $faker->dateTime,
        'latitude'       => $faker->latitude,
        'longitude'      => $faker->longitude,
        'deleted_at'     => null,
    ];
});
