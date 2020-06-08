<?php

/** @var Factory $factory */

use App\Http\Models\Permission;
use App\Http\Models\PermissionRole;
use App\Http\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(PermissionRole::class, function (Faker $faker) {
    return [
        'permission_id' => factory(Permission::class),
        'role_id'       => factory(Role::class),
        'level'         => $faker->numberBetween(0, 7),
    ];
});
