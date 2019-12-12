<?php

use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

$factory->define(App\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'uuid' => Uuid::uuid4()
    ];
});
