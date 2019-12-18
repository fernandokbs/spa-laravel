<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Comment;
use App\Author;
use App\User;
use App\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'email' => "testroot@gmail.com",
            'password' => Hash::make("testroot"),
        ]);

        factory(User::class)->create();
        factory(Article::class)->times(20)->create();
        factory(Comment::class)->times(10)->create();
    }
}
