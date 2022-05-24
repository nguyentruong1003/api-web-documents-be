<?php

namespace App\Http\Livewire\Admin\Post;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Post;
use App\Models\PostType;
use Livewire\Component;

class PostPendingList extends BaseLive
{
    public $searchType;
    public $editId, $check;

    public function mount() {
        $this->types = PostType::all();
        $this->model_name = Post::class;
    }

    public function render()
    {
        $query = Post::query()->whereIn('status', [0, 2]);

        if ($this->searchTerm) {
            $query->where('unsign_text', 'like', '%' . trim(removeStringUtf8($this->searchTerm)) . '%')
                ->orwhere('content', 'like', '%' . trim($this->searchTerm) . '%');
        }

        if ($this->searchType) {
            $query->where('post_type_id', $this->searchType);
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);
        return view('livewire.admin.post.post-pending-list', ['data' => $data]);
    }

    public function check($id)
    {
        # code...
        $this->editId = $id;
        $pr = Post::findorfail($this->editId);
        $this->check = true;
    }

    public function approve()
    {
        # code...
        $pr = Post::findorfail($this->editId);
        $pr->status = 1;
        $pr->save();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Phê duyệt thành công'] );
        $this->emit('close-modal');
    }

    public function decline()
    {
        # code...
        $pr = Post::findorfail($this->editId);
        $pr->status = 0;
        $pr->save();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Từ chối thành công'] );
        $this->emit('close-modal');
    }

    public function undo($id)
    {
        # code...
        $pr = Post::findorfail($id);
        $pr->status = 2;
        $pr->save();
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => 'Hoàn tác thao tác từ chối.'] );
    }
}
