<?php

namespace App\Editors;

use App\Helpers\Slug;

class PostTypeEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'name' => $this->data['name'],
            'parent_id' => $this->data['parent_id'],
            'slug' => Slug::slugify($this->data['name']),
        ]);
        $this->model->save();
    }
}
