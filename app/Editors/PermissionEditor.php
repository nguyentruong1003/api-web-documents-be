<?php

namespace App\Editors;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionEditor extends Editor
{

    public function handleSave()
    {
        if($this->model->exists) {
            $this->model->name = $this->data['name'];
            $this->model->save();
        } else {
            $this->model = Permission::create([
                'name' => $this->data['name']
            ]);
        }
    }
}
