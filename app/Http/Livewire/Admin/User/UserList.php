<?php

namespace App\Http\Livewire\Admin\User;

use App\Http\Livewire\Base\BaseLive;
use App\Models\Role;
use App\Models\User;
use DB;

class UserList extends BaseLive
{
    public $Id, $name, $email, $password, $password_confirmation;
    public $roles, $role;

    public function mount() {
        $this->roles = Role::all();
    }

    public function render() {
        $query = User::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . trim($this->searchTerm) . '%');
        }

        $data = $query->orderBy('created_at','asc')->paginate($this->perPage);

        return view('livewire.admin.user.user-list', compact('data'));
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
    }

    public function edit($id) {
        $this->checkEdit = true;
        $this->Id = $id;
        $user = User::findorfail($this->Id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = DB::table('model_has_roles')->where('model_id',$id)->pluck('role_id')->toArray();
        $this->emit('set-roles', $this->role);
    }

    public function save() {
        $this->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
        ], [], []);
        if ($this->checkEdit) {
            $user = User::findorfail($this->Id);
        } else {
            $user = new User();
        }
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->save();
        $this->emit('close-modal-create-update');
        if ($this->checkEdit) {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        } else
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.create')] );
        $this->resetInputFields();
    }

    public function updateRole() {
        $user = User::findorfail($this->Id);
        $user->syncRoles($this->role);
        $this->emit('close-modal-role');
        $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        $this->resetInputFields();
    }

    public function resetInputFields() {
        $this->reset(['Id','name','email','role','password','password_confirmation']);
        $this->resetValidation();
    }

    public function delete() {
        if ($this->deleteId == 1) {
            $this->dispatchBrowserEvent('show-toast', ['type' => 'error', 'message' => 'Bạn không thể xóa tài khoản admin']);
        } else {
            User::findOrFail($this->deleteId)->delete();
            $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
        }
    }
}
