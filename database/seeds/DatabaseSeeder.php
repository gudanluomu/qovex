<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Group;
use App\Models\Department;
use App\Models\Role;
use Illuminate\Support\Arr;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@xhl.com',
        ]);

        //创建权限
        \Illuminate\Support\Facades\Artisan::call('permission:create');

        $perms = \Spatie\Permission\Models\Permission::query()->get()->pluck('id')->all();

        for ($i = 0; $i < 10; $i++) {
            $user = factory(User::class)->create();

            $group = factory(Group::class)->create(['user_id' => $user->id]);

            $user->group_id = $group->id;
            $user->is_head = true;
            $user->save();

            /** @var Role $roles */
            $roles = factory(Role::class, 4)
                ->create(['group_id' => $group->id])
                ->each(function ($role) use ($perms) {
                    $role->givePermissionTo(Arr::random($perms, rand(1, count($perms))));
                })
                ->pluck('id')
                ->all();

            //部门
            factory(Department::class, 5)
                ->create(['group_id' => $group->id])
                ->each(function ($deparement) use ($roles) {
                    //上级
                    factory(User::class)
                        ->create(['department_id' => $deparement->id, 'department_type' => 2, 'group_id' => $deparement->group_id])
                        ->assignRole(Arr::random($roles));
                    //员工
                    factory(User::class, 8)
                        ->create(['department_id' => $deparement->id, 'department_type' => 1, 'group_id' => $deparement->group_id])
                        ->each(function ($user) use ($roles) {
                            $user->assignRole(Arr::random($roles));
                        });
                });
        }
    }

}
