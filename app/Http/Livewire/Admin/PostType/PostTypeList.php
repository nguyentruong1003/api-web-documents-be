<?php

namespace App\Http\Livewire\Admin\PostType;

use App\Http\Livewire\Base\BaseLive;
use App\Models\PostType;
use Livewire\Component;

class PostTypeList extends BaseLive
{
    public $name, $editId;

    public function render()
    {
        $query = PostType::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . trim($this->searchTerm) . '%');
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);
        return view('livewire.admin.post-type.post-type-list', ['data' => $data]);
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
    }

    public function edit($id) {
        $this->resetInputFields();
        $this->checkEdit = true;
        $this->editId = $id;
        $pt = PostType::findorfail($this->editId);
        $this->name = $pt->name;
    }

    public function save() {
        $this->validate([
            'name' => 'required|max: 255',
        ], [
            'name.required' => __('view.validation.required'),
        ]);
        if ($this->checkEdit) {
            PostType::findorfail($this->editId)->update([
                'name' => $this->name
            ]);
        } else {
            PostType::create([
                'name' => $this->name
            ]);
        }
        $this->emit('close-modal');
        if ($this->checkEdit) {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        } else
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.create')] );
        $this->resetInputFields();
    }

    public function resetInputFields() {
        $this->reset(['editId','name']);
        $this->resetSearch();
        $this->resetValidation();
    }

    public function delete() {
        PostType::findOrFail($this->deleteId)->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
    }
}
