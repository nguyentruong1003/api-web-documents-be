<?php

namespace App\Editors;

use App\Models\PostType;

class PostEditor extends Editor
{

    public function handleSave()
    {
        $this->model->fill([
            'title' => $this->data['title'],
            'description' =>  $this->data['description'],
            'content' => $this->data['content'],
            // 'post_type_id' => PostType::query()->where('name', ($this->data['post_type_id'] ?? null) )->id ?? null,
            'user_id' => auth()->user()->id,
        ]);
        $this->model->save();
    }
}
