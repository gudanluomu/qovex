<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.index');
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->with(['roles.permissions', 'department'])
            ->when($request->name, function ($query, $name) {
                $query->where('name', $name)
                    ->orWhere('email', $name);
            })
            ->when($request->department_id, function ($query, $department_id) {
                $query->where('department_id', $department_id);
            })
            ->when($request->department_type, function ($query, $department_type) {
                $query->where('department_type', $department_type);
            })
            ->paginate()
            ->appends($request->all());

        $departments = Department::query()->withDepth()->orderBy('_lft')->get();

        return view('user.index', compact('users', 'departments'));
    }

    public function create(User $user)
    {
        $roles = Role::query()->with('permissions')->get();

        $departments = Department::query()->withDepth()->orderBy('_lft')->get();

        return view('user.create', compact('roles', 'user', 'departments'));
    }

    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->all())->save();

        $user->assignRole($request->roles);

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        $roles = Role::query()->with('permissions')->get();

        $departments = Department::query()->withDepth()->orderBy('_lft')->get();

        return view('user.edit', compact('roles', 'user', 'departments'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->all())->save();

        $user->syncRoles($request->roles);

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }
}
