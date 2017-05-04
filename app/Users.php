<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $fillable = [
        'ip', 'browser', 'cookie','country', 'saved_hashes', 'origin_words'
    ];
    //
    protected $table = 'users';
}
