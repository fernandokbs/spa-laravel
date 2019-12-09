<?php

use Illuminate\Database\Seeder;
use App\Author;
use App\Book;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Author::class)->times(6)->create();
        factory(Book::class)->times(20)->create();
    }
}
