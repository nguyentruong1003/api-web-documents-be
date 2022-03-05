<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $routes = Route::getRoutes()->getRoutes();
        foreach ($routes as $route) {
            $action = $route->action;
            if (!isset($action['middleware'])) continue;
            if (isset($action['excluded_middleware']) && in_array('check-permission', $action['excluded_middleware'])) continue;
            if (!in_array('check-permission', $action['middleware'])) continue;
            Permission::findOrCreate($action['as'] ?? 'no-name');
        }
    }
}
