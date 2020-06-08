<?php

/** @var Factory $factory */

use App\Http\Models\Corporation;
use App\Http\Models\Group;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name'            => $faker->company(),
        'corporation_id'  => factory(Corporation::class),
        'parent_group_id' => null,
        'deleted_at'      => null,
    ];
});
