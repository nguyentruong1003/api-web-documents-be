<?php

namespace App\Http\Livewire\Admin\Post;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Post;
use App\Models\PostType;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostList extends BaseLive
{
    use WithFileUploads;
    public $searchType;
    public $editId, $title, $content, $description, $post_type_id, $link_pdf;
    public $file, $file_name;

    public function mount() {
        $this->types = PostType::all()->pluck('id', 'name');
    }

    public function render() {
        $query = Post::query();

        if ($this->searchTerm) {
            $query->where('title', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('content', 'like', '%' . trim($this->searchTerm) . '%');
        }

        if ($this->searchType) {
            $query->where('type', $this->searchType);
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);

        return view('livewire.admin.post.post-list', ['data' => $data]);
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
        $this->emit('set-content', null);
    }

    public function edit($id) {
        $this->checkEdit = true;
        $this->editId = $id;
        $item = Post::findorfail($this->editId);
        $this->title = $item->title;
        $this->description = $item->description;
        $this->content = $item->content;
        $this->post_type_id = $item->post_type_id;
        $this->emit('set-content', $item->content);
        
    }

    public function save() {
        // $this->validate([
        // ], [
            
        // ]);
        if ($this->checkEdit) {
            $item = Post::findorfail($this->editId);
        } else {
            $item = new Post();
        }
        $item->title = $this->title;
        $item->description = $this->description;
        $item->content = $this->content;
        $item->post_type_id = $this->post_type_id;
        $item->link_pdf = ($this->file) ? $this->file->store('public') : null;
        $item->save();
        $this->emit('close-modal');
        if ($this->checkEdit) {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        } else
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.create')] );
        $this->resetInputFields();
    }

    public function resetInputFields() {
        $this->reset(['editId','title','description','post_type_id','content','link_pdf', 'file', 'file_name']);
        $this->resetValidation();
    }

    public function updatingSearchType() {
        $this->resetPage();
    }

    public function delete() {
        $user = Post::findOrFail($this->deleteId);
        $user->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
    }
}
