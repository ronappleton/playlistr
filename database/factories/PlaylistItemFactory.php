<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PlaylistItem;
use Faker\Generator as Faker;

$factory->define(PlaylistItem::class, function (Faker $faker) {

    return [
        'playlist_id' => $faker->word,
        'name' => $faker->word,
        'url' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s'),
        'deleted_at' => $faker->date('Y-m-d H:i:s')
    ];
});
