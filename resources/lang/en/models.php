<?php

return [
    'user' => [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'password_confirmation' => 'Password confirmation',
        'old_password' => 'Old password',
        'new_password' => 'New password',
        'new_password_confirmation' => 'New password confirmation',
        'role_id' => 'Role',
    ],
    'role' => [
        'user_id' => 'User',
        'permission_id' => 'Permission',
        'name' => 'Name',
        'guard_name' => 'Guard name'
    ],
    'permission' => [
        'name' => 'Name',
        'guard_name' => 'Guard name'
    ],
    'master_data' => [
        'v_key' => 'Data type name',
        'v_value' =>  'Data of type',
        'order_number' => 'Order Number',
        'type' => 'Type',
        'parent_id' => 'Parent ID',
        'v_content' => 'Content',
        'note' => 'Note',
    ],
];
