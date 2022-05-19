<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\PostReport;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UnsignTextSearchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->insertData(User::all(), 'name');
        $this->insertData(Role::all(), 'name');
        $this->insertData(Comment::all(), 'comment');
        $this->insertData(PostReport::all(), 'description');
    }

    public function insertData($data, $column) {
        foreach ($data as $item) {
            $unsign_text = '';
            $separate = '';
            $item->unsign_text = $unsign_text . $separate . removeStringUtf8($item->$column);
            $item->save();
        }
    }
}
