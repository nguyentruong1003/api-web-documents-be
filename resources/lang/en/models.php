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
];
