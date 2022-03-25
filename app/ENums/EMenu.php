<?php


namespace App\Enums;

class EMenu
{

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
}
