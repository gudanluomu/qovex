<?php


namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider as Provider;

class EloquentUserProvider extends Provider
{
    /**
     * Get a new query builder for the model instance.
     *
     * @param \Illuminate\Database\Eloquent\Model|null $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newModelQuery($model = null)
    {
        $model = is_null($model)
            ? $this->createModel()->newQuery()
            : $model->newQuery();

        return $model->withoutGlobalScopes();
    }
}
