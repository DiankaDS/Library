<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'giving_id', 'taker_id', 'date_start', 'date_end', 'book_id'
    ];

}
