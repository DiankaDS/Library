<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibBook extends Model
{
    protected $fillable = [
        'name', 'genre_id', 'year', 'description',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\Author');
    }

}
