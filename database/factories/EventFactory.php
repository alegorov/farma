<?php

use Faker\Generator as Faker;

$factory->define(\App\Event::class, function (Faker $faker) {
    return [
        'name' => 'Laravel and Coffee',
        'enabled' => 1,
        'created_at' => '2017-12-01 15:00:00',
        'updated_at' => '2017-12-01 15:00:00',
        'venue' => 'City Coffee Shop',
        'city' => 'Dublin',
        'description' => "Let's drink coffee and learn Laravel together!"
    ];
});

$factory->state(App\Event::class, 'incorrect_capitalization', [
    'name' => 'have fun WITH the raspberry pi',
]);

$factory->state(App\Event::class, 'city', [
    'name' => 'have fun WITH the raspberry pi',
]);

$factory->state(App\Event::class, 'zip', [
    'name' => 'have fun WITH the raspberry pi',
]);
