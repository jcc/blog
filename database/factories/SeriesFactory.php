<?php

use Faker\Generator as Faker;

$factory->define(App\Series::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
	    'description' => $faker->sentence.". ".$faker->sentence.". ".$faker->sentence
    ];
});
