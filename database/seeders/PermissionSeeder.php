<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = ['index', 'create', 'edit', 'delete', 'show', 'upload', 'download'];

        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route) {
            if (!isset($route->action['middleware'])) continue;
            if (isset($route->action['excluded_middleware']) && in_array('check-permission', $route->action['excluded_middleware'])) continue;
            if (!in_array('check-permission', $route->action['middleware'])) continue;
            
            $routeName = $route->action['as'] ?? 'route-name';
            if (strpos($routeName, '.index') > 0) {
                $arr = explode('.', $routeName);
                array_pop($arr);
                foreach ($actions as $action) {
                    Permission::query()->firstOrCreate([
                        'alias' => join('-', $arr),
                        'code' => join('.', $arr) . '.index',
                        'name' => join('.', $arr) . '.' . $action,
                        'action' => $action,
                    ]);
                }
            }
        }

        $role = Role::findOrCreate('administrator');
        $permissions = Permission::all();

        $role->syncPermissions($permissions);

        $role2 = Role::findOrCreate('guest');
        $role2->syncPermissions(Permission::where('action', 'index')->pluck('id')->toArray());
    }
}
