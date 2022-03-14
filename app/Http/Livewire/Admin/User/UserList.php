<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Base\BaseLive;
use App\Models\User;
use Livewire\Component;

class UserList extends BaseLive
{
    public function render() {
        $query=User::query();

        $data=$query->orderBy('created_at','desc')->paginate($this->perPage);

        return view('livewire.admin.user.user-list' ,compact('data'));
    }

    public function delete() {
        $user = User::findOrFail($this->deleteId);
        $user->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => 'Xóa người dùng thành công']);
    }
}
