<?php

namespace App\Http\Livewire\Admin\Post;

use App\Http\Livewire\Base\BaseLive;
use App\Models\File;
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
    public $types, $model_name;

    public function mount() {
        $this->types = PostType::all();
        $this->model_name = Post::class;
    }

    public function render() {
        $query = Post::query();

        if ($this->searchTerm) {
            $query->where('unsign_text', 'like', '%' . trim(removeStringUtf8($this->searchTerm)) . '%')
                ->orwhere('content', 'like', '%' . trim($this->searchTerm) . '%');
        }

        if ($this->searchType) {
            $query->where('post_type_id', $this->searchType);
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);

        return view('livewire.admin.post.post-list', ['data' => $data]);
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
        $this->emit('set-content', null);
        $this->emit('setModelId');
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
        $this->emit('setModelId', $this->editId);
        
    }

    public function save() {
        $this->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề bắt buộc'
        ]);
        if ($this->checkEdit) {
            $item = Post::findorfail($this->editId);
        } else {
            $item = new Post();
        }
        $item->title = $this->title;
        $item->description = $this->description;
        $item->content = $this->content;
        $item->post_type_id = $this->post_type_id;
        $item->user_id = auth()->user()->id;
        // $item->link_pdf = ($this->file) ? $this->file->store('public') : null;
        $item->save();
        if (count($item->files) > 0) {
            if (count(getFileOnGoogleDriveServer($item->files[0]->id)) > 0) {
                $item->link_pdf = getFileOnGoogleDriveServer($item->files[0]->id)['link'];
                $item->save();
            }
        }
        $this->emit('saveFile', $item->id);
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
        $this->emit('delete-file', Post::class, $this->deleteId);
        $user->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
    }
}
