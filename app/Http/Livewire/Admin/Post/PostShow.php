<?php

namespace App\Http\Livewire\Admin\Post;

use App\Http\Livewire\Base\BaseLive;
use Livewire\Component;

class PostShow extends BaseLive
{
    public function mount($data)
    {
        # code...
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.admin.post.post-show');
    }
}
