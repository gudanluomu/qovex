<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::query()
            ->when($request->name, function ($query, $name) {
                $query->where('name', 'like', "%{$name}%");
            })
            ->paginate()
            ->appends($request->all());

        return view('role.index', compact('roles'));
    }

    public function create(Role $role)
    {
        $permissions = Permission::query()->get(['id', 'cname']);

        return view('role.create', compact('permissions', 'role'));
    }

    public function store(RoleRequest $request)
    {

        $role = Role::create($request->only(['name']));

        $role->givePermissionTo($request->permissions);

        return redirect()->route('role.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::query()->get(['id', 'cname']);

        return view('role.edit', compact('permissions', 'role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->fill($request->only(['name']))->save();

        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('role.index');
    }
}
