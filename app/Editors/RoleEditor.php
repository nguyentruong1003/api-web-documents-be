<?php

namespace App\Editors;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleEditor extends Editor
{

    public function handleSave()
    {
        if($this->model->exists) {
            $this->model->name = $this->data['name'];
            $this->model->save();
        } else {
            $this->model = Role::create([
                'guard_name' => 'api',
                'name' => $this->data['name']
            ]);
        }
        if (isset($this->data['permissions'])) {
            $this->model->syncPermissions($this->data['permissions']);
        }

        if (isset($this->data['users'])) {
            foreach($this->data['users'] as $userId) {
               User::query()->find($userId)->syncRoles($this->model);
            }
        }

    }
}
