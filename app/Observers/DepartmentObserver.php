<?php

namespace App\Observers;

use App\Models\Department;

class DepartmentObserver extends BaseObserver
{
    public function creating(Department $department)
    {
        $this->groupId($department);
    }
}
