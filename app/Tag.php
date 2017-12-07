<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    protected $fillable = [
        'name',
    ];

    public function books()
    {
        return $this->belongsToMany('App\LibBook', 'tags_books', 'tag_id', 'book_id');
    }

    public $timestamps = false;
}
