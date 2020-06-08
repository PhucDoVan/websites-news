<?php

/** @var Factory $factory */

use App\Http\Models\Account;
use App\Http\Models\Corporation;
use App\Http\Models\Group;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Account::class, function (Faker $faker) {
    $characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $username   = $faker->unique()->regexify("[$characters]{5}");

    return [
        'corporation_id'             => factory(Corporation::class),
        'group_id'                   => factory(Group::class),
        'username'                   => function (array $account) use ($username) {
            $uid = Corporation::find($account['corporation_id'])->uid;
            return "$uid-$username";
        },
        'password'                   => bcrypt($faker->password(8)),
        'name_last'                  => $faker->lastName,
        'name_first'                 => $faker->firstName,
        'kana_last'                  => $faker->lastKanaName,
        'kana_first'                 => $faker->firstKanaName,
        'email'                      => $faker->unique()->safeEmail(),
        't_service_id'               => null,
        'deleted_at'                 => null,
        'shikakumap_registered_at'   => $faker->dateTime,
        'shikakumap_deregistered_at' => $faker->dateTime,
    ];
});
