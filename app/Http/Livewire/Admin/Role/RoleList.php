<?php

namespace App\Http\Livewire\Admin\Role;

use App\Http\Livewire\Base\BaseLive;
use Spatie\Permission\Models\Role;
use App\Models\RoleHasPermisson;
use Spatie\Permission\Models\Permission;

class RoleList extends BaseLive
{

    public $Id, $name;
    public $permissions, $permission;
    public $selectedPermissions = [];

    public static function listNameMenu()
    {
        return [
            'user.index' => 'Quản lý người dùng',
            'role.index' => 'Quản lý vai trò',
            'permission.index' => 'Quản lý phân quyền',
            'master-data.index' => 'Quản lý cấu hình',
            'audit.index' => 'Audit log',
        ];
    }

    public function mount() {
        $this->permissions = Permission::query()->get()->groupBy('alias')->map(function ($item) {
            return $item->groupBy('code');
        })->toArray();
        $this->listNameMenu = $this->listNameMenu();
    }

    public function render() {
        $query = Role::query();

        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . trim($this->searchTerm) . '%');
        }

        $data = $query->orderBy('created_at','asc')->paginate($this->perPage);

        return view('livewire.admin.role.role-list', compact('data'));
    }

    public function create() {
        $this->resetInputFields();
        $this->checkEdit = false;
    }

    public function edit($id) {
        $this->resetInputFields();
        $this->checkEdit = true;
        $this->Id = $id;
        $role = Role::findorfail($id);
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function save() {
        $this->validate([
            'name' => 'required',
        ]);
        if ($this->checkEdit) {
            $role = Role::findorfail($this->Id);
        } else {
            $role = new Role();
            $role->guard_name = 'api';
        }
        $role->name = $this->name;
        $role->syncPermissions($this->selectedPermissions);
        $role->save();
        $this->emit('close-modal');
        if ($this->checkEdit) {
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.update')] );
        } else
            $this->dispatchBrowserEvent('show-toast', ["type" => "success", "message" => __('view.notification.success.create')] );
        $this->resetInputFields();
    }

    public function resetInputFields() {
        $this->reset(['Id','name','permission', 'selectedPermissions']);
        $this->resetValidation();
    }

    public function delete() {
        $user = Role::findOrFail($this->deleteId);
        $user->delete();
        $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
    }

    function getRolePermissions ($idRole) {
        $rolePermissions = RoleHasPermisson::where('role_has_permissions.role_id', $idRole)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        $dataPermission = [];
        foreach ($rolePermissions as $permission) {
            $dataPermission[] = $permission;
        }
        return $dataPermission;
    }
}
