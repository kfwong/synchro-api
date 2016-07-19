<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'ivle_id' => $faker->randomLetter . $faker->randomNumber(7),
        'email' => $faker->email,
        'gender' => $faker->randomElement(['Male', 'Female']),
        'faculty' => $faker->sentence(3),
        'first_major' => $faker->sentence(3),
        'second_major' => $faker->sentence(3),
        'matriculation_year' => $faker->year,
        'last_seen_at' => $faker->dateTime,
        'last_sync_at' => $faker->dateTime
    ];
});

$factory->define(App\Group::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
    ];
});

$factory->define(App\Tag::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->word
    ];
});

$factory->define(App\Module::class, function (Faker\Generator $faker){
    return [
        'module_code' =>  $faker->randomLetter . $faker->randomLetter . $faker->randomNumber(4),
        'module_title' => $faker->sentence
    ];
});

$factory->define(App\Post::class, function(Faker\Generator $faker){
    return [
        'content' => $faker->paragraph
    ];
});