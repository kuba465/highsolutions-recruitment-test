<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Http\Models\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'height' => (string)$faker->randomDigit,
        'mass' => (string)$faker->randomDigit,
        'hair_color' => $faker->colorName,
        'skin_color' => $faker->colorName,
        'eye_color' => $faker->colorName,
        'birth_year' => $faker->text(10),
        'gender' => $faker->randomElement(['male', 'female']),
        'homeworld' => $faker->text(20),
        'films' => ['a', 'b', 'c'],
        'species' => ['a', 'b', 'c'],
        'vehicles' => ['a', 'b', 'c'],
        'starships' => ['a', 'b', 'c'],
        'created' => $faker->dateTime,
        'edited' => $faker->dateTime,
        'url' => $faker->url
    ];
});
