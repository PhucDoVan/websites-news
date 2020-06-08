<?php

/** @var Factory $factory */

use App\Http\Models\Account;
use App\Http\Models\ModelHasRoles;
use App\Http\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(ModelHasRoles::class, function (Faker $faker) {
    return [
        'role_id'    => factory(Role::class),
        'model_type' => 'App\Http\Models\Account',
        'model_id'   => factory(Account::class),
    ];
});
