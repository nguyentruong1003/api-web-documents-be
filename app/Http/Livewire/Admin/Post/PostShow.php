<?php

namespace App\Http\Livewire\Admin\Post;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Post;
use Livewire\Component;

class PostShow extends BaseLive
{
    public $data, $model_name, $model_id;

    public function mount($data)
    {
        # code...
        $this->data = $data;
        $this->model_id = $data->id;
        $this->model_name = Post::class;
    }

    public function render()
    {
        return view('livewire.admin.post.post-show');
    }
}
