<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index(Request $request)
    {
        $users = User::query()
            ->with('roles')
            ->when($request->name, function ($query, $name) {
                $query->where('name', $name)
                    ->orWhere('email', $name);
            })
            ->paginate()
            ->appends($request->all());

        $departments = Department::query()->withDepth()->orderBy('_lft')->get();

        return view('user.index', compact('users', 'departments'));
    }

    public function create(User $user)
    {
        $roles = Role::query()->with('permissions')->get();

        return view('user.create', compact('roles', 'user'));
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

        return view('user.edit', compact('roles', 'user'));
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
