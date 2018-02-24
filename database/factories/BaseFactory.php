<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Channel::class, function (Faker $faker) {
    return [
        'display_name' => $faker->word,
        'icon_src' => $faker->url,
    ];
});

$factory->define(App\Models\Programme::class, function (Faker $faker) {

    $channel = factory(App\Models\Channel::class)->create();

    return [
        'channel_id' => $channel->id,
        'start' => $faker->dateTime(),
        'stop' => $faker->dateTime(),
        'title' => $faker->word,
        'descr' => $faker->word,
        'date' => $faker->date(),
    ];
});

$factory->define(App\Models\ScrapChannel::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'url' => $faker->url,
        'parsed_at' => $faker->dateTime
    ];
});
