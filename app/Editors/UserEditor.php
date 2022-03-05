<?php

namespace App\Editors;

class UserEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill(array_merge($this->data, [
            'password' => bcrypt($this->data['password'])
        ]));

        $this->model->save();

        if (isset($this->data['roles'])) {
            $this->model->syncRoles($this->data['roles']);
        }
    }
}
