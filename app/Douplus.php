<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Douplus extends Model
{
    protected $casts = [
        'info' => 'array',
        'contents' => 'array'
    ];
}
