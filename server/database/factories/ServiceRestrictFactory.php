<?php

/** @var Factory $factory */

use App\Http\Models\Account;
use App\Http\Models\ServiceRestrict;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ServiceRestrict::class, function (Faker $faker) {
    return [
        'account_id' => factory(Account::class),
        'type'       => 10,
        'value'      => $faker->ipv4,
        'deleted_at' => null,
    ];
});
