<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'desc', 'user_id'];

    //团长
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
