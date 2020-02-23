<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ApiRoute;
use Faker\Generator as Faker;

$factory->define(ApiRoute::class, function (Faker $faker) {

    return [
        'route' => $faker->word,
        'description' => $faker->word,
        'active' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
