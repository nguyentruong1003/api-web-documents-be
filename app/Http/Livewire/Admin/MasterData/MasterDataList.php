<?php

namespace App\Http\Livewire\Admin\MasterData;

use App\Http\Livewire\Base\BaseLive;
use App\Models\MasterData;

class MasterDataList extends BaseLive
{

    public $searchType;
    public $Id, $v_key, $v_value, $order_number, $v_content, $parent_id, $type, $note;

    public function render() {
        $query = MasterData::query();

        if ($this->searchTerm) {
            $query->where('v_key', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('v_value', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('order_number', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('v_content', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('note', 'like', '%' . trim($this->searchTerm) . '%')
                ->orwhere('parent_id', 'like', '%' . trim($this->searchTerm) . '%');
        }

        if ($this->searchType) {
            $query->where('type', $this->searchType);
        }

        $data = $query->orderBy('created_at','desc')->paginate($this->perPage);

        return view('livewire.admin.master-data.master-data-list', compact('data'));
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
    }

    public function edit($id) {
        $this->checkEdit = true;
        $this->Id = $id;
        $md = MasterData::findorfail($this->Id);
        $this->v_key = $md->v_key;
        $this->v_value = $md->v_value;
        $this->order_number = $md->order_number;
        $this->type = $md->type;
        $this->parent_id = $md->parent_id;
        $this->v_content = $md->v_content;
        $this->note = $md->note;
    }

    public function save() {
        $this->validate([
            'v_key' => 'required',
            'v_value' => 'required',
            'type' => 'required|digits_between:0,2',
        ], [
            'v_key.required' => __('view.validation.required'),
        ]);
        if ($this->checkEdit) {
            $md = MasterData::findorfail($this->Id);
        } else {
            $md = new MasterData();
        }
        $md->v_key = $this->v_key;
        $md->v_value = $this->v_value;
        $md->type = $this->type;
        $md->parent_id = $this->parent_id;
        $md->v_content = $this->v_content;
        $md->note = $this->note;
        $md->order_number = $this->order_number;
        $md->save();
        $this->emit('close-modal');
        if ($this->checkEdit) {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        } else
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.create')] );
        $this->resetInputFields();
    }

    public function resetInputFields() {
        $this->reset(['Id','v_key','v_value','type','parent_id','order_number', 'v_content', 'note']);
        $this->resetSearch();
        $this->resetValidation();
    }

    public function updatingSearchType() {
        $this->resetPage();
    }

    public function delete() {
        $user = MasterData::findOrFail($this->deleteId);
        $user->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
    }
}

