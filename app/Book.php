<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','content','thumbnail','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function countComments()
    {
        return $this->comments->count();
    }

    public function score()
    {
        $score = $this->comments->pluck('score');
        return  $score->count() > 0 ? ($score->sum() / $score->count()) : 0;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
