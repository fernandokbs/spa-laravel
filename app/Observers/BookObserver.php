<?php

namespace App\Observers;

use App\Book;
use Illuminate\Support\Str;

class BookObserver
{
    public function saving($book)
    {
        $slug = Str::slug($book->title, '-');
        
        if(Book::where('slug', $slug)->exists())
            $slug = $slug . uniqid();

        $book->slug = $slug;
    }
}
