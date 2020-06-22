<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Department extends Model
{
    use NodeTrait;

    protected $fillable = ['name', 'parent_id'];

    public function getTreeNameAttribute()
    {
        if ($this->depth < 1)
            return $this->name;

        return '|' . str_repeat('_', $this->depth * 5) . $this->name;
    }
}
