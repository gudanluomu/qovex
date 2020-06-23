<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver
{
    public function creating(Department $department)
    {
        $department->group_id = auth()->user()->group_id;
    }
}
