<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permission2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        {
            $this->seedPermission('user', ['get-posts', 'get-files']);
    
            $role2 = Role::where('name', 'normal user')->first();
            $role2->givePermissionTo([
                'user.get-posts',
                'user.get-files',
            ]);
        }
    }

    public function seedPermission($module, $actions) {
        foreach ($actions as $action) {
            Permission::query()->firstOrCreate([
                'module' => $module,
                'name' => $module . '.' . $action,
                'action' => $action,
            ]);
        }
    }
}
