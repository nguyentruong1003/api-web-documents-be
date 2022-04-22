<?php

namespace App\Editors;

use App\Models\PostType;

class PostEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'title' => $this->data['title'],
            'description' =>  $this->data['description'] ?? null,
            'content' => $this->data['content'] ?? null,
            // 'post_type_id' => PostType::query()->where('name', ($this->data['post_type_id'] ?? null) )->id ?? null,
            'post_type_id' => $this->data['post_type_id'] ?? null,
            'user_id' => auth()->user()->id,
        ]);
        $this->model->save();
    }
}
