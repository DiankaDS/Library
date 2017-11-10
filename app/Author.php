<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany('App\LibBook', 'authors_books', 'author_id', 'book_id');
    }

    public $timestamps = false;
}
