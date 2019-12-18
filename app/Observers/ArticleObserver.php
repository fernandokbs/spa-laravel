<?php

namespace App\Observers;

use App\Article;
use Illuminate\Support\Str;

class ArticleObserver
{
    public function saving($Article)
    {
        $slug = Str::slug($Article->title, '-');
        
        if(Article::where('slug', $slug)->exists())
            $slug = $slug . uniqid();

        $Article->slug = $slug;
    }
}
