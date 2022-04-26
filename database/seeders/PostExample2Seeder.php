<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\PostReport;
use Illuminate\Database\Seeder;

class PostExample2Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Post::factory()->times(100)->create();
        Comment::factory()->times(50)->create();
        PostReport::factory()->times(50)->create();
    }
}
