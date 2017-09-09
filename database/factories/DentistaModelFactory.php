<?php

use Faker\Generator as Faker;

$factory->define(App\Dentista::class, function (Faker $faker) {
    return [
        'nome'=>$faker->name
    ];
});
