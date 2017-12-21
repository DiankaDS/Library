<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    protected $fillable = [
        'name',
    ];

//    public function books()
//    {
//        return $this->belongsToMany('App\LibBook', 'formats_users_books', 'format_id', 'book_id');
//    }
//
//    public function users()
//    {
//        return $this->belongsToMany('App\User', 'formats_users_books', 'format_id', 'user_id');
//    }

    public $timestamps = false;
}
