<?php

namespace Database\Seeders;

use App\Helpers\Slug;
use App\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypeSlugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = PostType::all();
        foreach ($data as $item) {
            $item->slug = Slug::slugify($item->name);
            $item->save();
        }
    }
}
