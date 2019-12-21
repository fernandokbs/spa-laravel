<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['title','content','score','user_id','article_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
