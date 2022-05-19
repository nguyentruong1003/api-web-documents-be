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

    public function mount() {
        $this->permissions = Permission::query()->get()->groupBy('module')->toArray();
        
        $this->listNameMenu = [
            'user' => 'Quản lý người dùng',
            'role' => 'Quản lý vai trò',
            'permission' => 'Quản lý phân quyền',
            'master-data' => 'Quản lý cấu hình',
            'audit' => 'Audit log',
            'post' => 'Quản lý bài viết',
            'post-type' => 'Quản lý loại bài viết',
            'report' => 'Quản lý phản hồi',
        ];
        
        $this->listNameGrant = [
            'index' => 'Danh sách',
            'create' => 'Thêm mới',
            'edit' => 'Chỉnh sửa',
            'delete' => 'Xóa',
            'show' => 'Chi tiết',
            'grant' => 'Phân quyền',
            'comment' => 'Bình luận',
            'editComment' => 'Chỉnh sửa bình luận',
            'deleteComment' => 'Xóa bình luận',
            'report' => 'Báo cáo - Phản hồi',
            'like' => 'Đánh dấu yêu thích bài viết',
            'likeComment' => 'Đánh dấu yêu thích bình luận',
            'solve' => 'Giải quyết phản hồi',
            'get-likes' => 'Lấy danh sách yêu thích',
            'get-reports' => 'Lấy danh sách báo cáo',
        ];
    }

    public function render() {
        $query = Role::query();

        if ($this->searchTerm) {
            $query->where('unsign_text', 'like', '%' . strtolower(trim(removeStringUtf8($this->searchTerm))) . '%');
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
        if ($this->deleteId == 1) {
            $this->dispatchBrowserEvent('show-toast', ['type' => 'error', 'message' => 'Bạn không thể xóa vai trò admin']);
        } else {
            Role::findOrFail($this->deleteId)->delete();
            $this->dispatchBrowserEvent('show-toast', ['type' => 'success', 'message' => __('view.notification.success.delete')]);
        }
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
