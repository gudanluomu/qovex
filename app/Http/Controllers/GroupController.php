<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:group.index');
    }

    public function index(Request $request)
    {
        $groups = Group::query()
            ->with('user')
            ->when($request->name, function ($query, $name) {
                $query->where('name', $name);
            })
            ->paginate()
            ->appends($request->all());

        return view('group.index', compact('groups'));
    }

    public function create(Group $group)
    {
        $users = User::query()->get(['id', 'name']);
        return view('group.create', compact('group', 'users'));
    }

    public function edit(Group $group)
    {
        $users = User::query()->get(['id', 'name']);
        return view('group.edit', compact('group', 'users'));
    }

    public function store(GroupRequest $request, Group $group)
    {
        $user = User::query()->findOrFail($request->user_id);

        $group->fill($request->all())->save();

        $user->group_id = $group->id;
        $user->is_head = true;
        $user->save();

        return redirect()->route('group.index');
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->user()->update(['is_head' => false]);

        $user = User::query()->findOrFail($request->user_id);

        $group->fill($request->all())->save();

        $user->group_id = $group->id;
        $user->is_head = true;
        $user->save();

        return redirect()->route('group.index');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('group.index');
    }

}
