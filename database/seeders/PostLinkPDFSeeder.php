<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostLinkPDFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $posts = Post::all();
        foreach ($posts as $post) {
            $post->user_id = 1;
            if (count($post->files) > 0) {
                if (count(getFileOnGoogleDriveServer($post->files[0]->id)) > 0) {
                    $post->link_pdf = getFileOnGoogleDriveServer($post->files[0]->id)['link'];
                    $post->save();
                }
            }
        }
    }
}
