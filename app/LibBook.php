<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibBook extends Model
{
    protected $fillable = [
        'name', 'genre_id', 'year', 'description', 'photo',
    ];

    public function authors()
    {
        return $this->belongsToMany('App\Author', 'authors_books', 'book_id', 'author_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_books', 'book_id', 'user_id')->withTimestamps();
    }

}
