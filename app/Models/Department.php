<?php

namespace App\Models;

use App\Scopes\RuleScope;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model
{
    use NodeTrait;

    protected $fillable = ['name', 'parent_id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new RuleScope());
    }

    //员工关联
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
