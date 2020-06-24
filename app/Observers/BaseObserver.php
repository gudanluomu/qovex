<?php


namespace App\Observers;


use Illuminate\Database\Eloquent\Model;

class BaseObserver
{
    public function groupId(Model $model)
    {
        if (auth()->check())
            $model->group_id = auth()->user()->group_id;
    }
}
