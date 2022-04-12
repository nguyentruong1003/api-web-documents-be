<?php

namespace App\Editors;

class PostTypeEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'name' => $this->data['name'],
        ]);
        $this->model->save();
    }
}
