<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call([
            PermissionSeeder::class,
            CreateAdminSeeder::class,
            PostTypeSeeder::class,
            PostExampleSeeder::class,
            PostExample2Seeder::class,
        ]);
    }
}
