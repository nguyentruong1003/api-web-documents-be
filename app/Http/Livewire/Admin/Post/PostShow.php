<?php

namespace App\Http\Livewire\Admin\Post;

use Livewire\Component;

class PostShow extends Component
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
