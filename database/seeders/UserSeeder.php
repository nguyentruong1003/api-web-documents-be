<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@test.com'
        ], [
            'password' => bcrypt('12345678')
        ]);

        $user->assignRole('administrator');
    }
}
