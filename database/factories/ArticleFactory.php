<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Article;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'user_id' => User::all()->random(),
        'content' => $faker->text($maxNbChars = 1200),
        'thumbnail' => 'https://picsum.photos/250/200'
    ];
});
