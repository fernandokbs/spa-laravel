<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'book_id' => Book::all()->random()->id,
        'user_id' => Book::all()->random()->id,
        'content' => $faker->text($maxNbChars = 200),
        'score' => $faker->numberBetween(1,5)
    ];
});
