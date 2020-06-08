<?php

/** @var Factory $factory */

use App\Http\Models\Account;
use App\Http\Models\Service;
use App\Http\Models\Token;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Token::class, function (Faker $faker) {
    return [
        'account_id' => factory(Account::class),
        'service_id' => factory(Service::class),
        'token'      => $faker->unique()->uuid,
        'expires_in' => now()->add('1 hour'),
    ];
});
