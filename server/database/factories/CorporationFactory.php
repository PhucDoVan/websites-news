<?php

/** @var Factory $factory */

use App\Http\Models\Corporation;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Corporation::class, function (Faker $faker) {
    $characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $uid        = $faker->unique()->regexify("[$characters]{3}");

    return [
        'name'         => $faker->company,
        'kana'         => $faker->company,
        'uid'          => $uid,
        'postal'       => $faker->postcode,
        'address_pref' => $faker->prefecture(),
        'address_city' => $faker->city(),
        'address_town' => $faker->ward(),
        'address_etc'  => $faker->streetAddress(),
        'deleted_at'   => null,
    ];
});
