<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Book;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'author_id' => Author::all()->random(),
        'user_id' => User::all()->random(),
        'content' => $faker->text($maxNbChars = 200),
        'thumbnail' => 'https://picsum.photos/250/500'
    ];
});
