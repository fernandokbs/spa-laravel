<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Article;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'Article_id' => Article::all()->random()->id,
        'user_id' => Article::all()->random()->id,
        'content' => $faker->text($maxNbChars = 200),
        'score' => $faker->numberBetween(1,5)
    ];
});
