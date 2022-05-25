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
        $this->seedPermission('user', ['index', 'create', 'edit', 'delete', 'show', 'grant', 'get-likes', 'get-reports', 'get-posts', 'get-files']);
        $this->seedPermission('role', ['index', 'create', 'edit', 'delete', 'show']);
        $this->seedPermission('audit', ['index', 'show']);
        $this->seedPermission('post', ['create', 'edit', 'delete', 'comment', 'editComment', 'deleteComment', 'report', 'like', 'likeComment']);
        $this->seedPermission('post-type', ['create', 'edit', 'delete']);
        $this->seedPermission('report', ['index', 'solve']);

        $role = Role::findOrCreate('administrator');
        $role->syncPermissions(Permission::all());

        $role2 = Role::findOrCreate('normal user');
        $role2->givePermissionTo([
            'user.index',
            'role.index',
            'post.comment',
            'post.editComment',
            'post.deleteComment',
            'post.report',
            'post.like',
            'post.likeComment',
            'user.get-likes',
            'user.get-reports',
            'user.get-posts',
            'user.get-files',
        ]);
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
