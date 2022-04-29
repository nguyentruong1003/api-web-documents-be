<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        // $this->posts();
        $sql_1 = file_get_contents(database_path('sql/posts.sql'));
        $sql_2 = file_get_contents(database_path('sql/files.sql'));
        DB::unprepared($sql_1);
        DB::unprepared($sql_2);
    }

    public function posts()
    {
        $data = require_once('database/raw/PostData.php');
        foreach ($data as $item) {
            Post::query()->firstOrCreate([
                'id' => $item['id'],
                'title' => $item['title'],
                'description' => $item['description'] ?? '',
                'content' => $item['content'] ?? '',
                'post_type_id' => $item['post_type_id'] ?? '',
                'status' => '1',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (isset($item['file'])) {
                File::query()->firstOrCreate([
                    'url' => $item['file']['url'],
                    'file_name' => $item['file']['file_name'],
                    'model_id' => $item['id'],
                    'model_name' => Post::class,
                    'admin_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        echo "Seeded: Post Data" . PHP_EOL;
        echo "Seeded: File Data" . PHP_EOL;
    }
}
