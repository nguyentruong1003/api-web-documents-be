<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::query()->firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);

        $admin->assignRole('administrator');

        $user = User::query()->firstOrCreate([
            'name' => 'Guest',
            'email' => 'guest@test.com',
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('guest');
    }
}
