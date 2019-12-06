<?php

use Illuminate\Database\Seeder;
use App\Author;

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
    }
}
