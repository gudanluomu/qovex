<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function store(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->all())->save();

        return back();
    }

    public function show(Department $department)
    {
        return new DepartmentResource($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->fill($request->all())->save();

        return back();
    }

    public function destroy(DepartmentRequest $request,Department $department)
    {
        $department->delete();

        return back();
    }

}
