<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name'];

    public function Articles()
    {
        return $this->hasMany(Article::class);
    }
}
