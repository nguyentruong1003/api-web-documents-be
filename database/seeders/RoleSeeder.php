<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrCreate('administrator');
        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        $role2 = Role::findOrCreate('guest');
        $role2->syncPermissions(Permission::where('action', 'index')->pluck('id')->toArray());
    
    }
}
