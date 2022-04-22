<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('post_type')->insert([
            [
                'id' => '1',
                'name' => 'Tài liệu chung',
                'parent_id' => null,
            ], 

            [
                'id' => '2',
                'name' => 'Các trường',
                'parent_id' => null,
            ],

            [
                'id' => '3',
                'name' => 'Đề thi đại học',
                'parent_id' => null,
            ], 

            [
                'id' => '4',
                'name' => 'Tin tức',
                'parent_id' => null,
            ], 

            [
                'id' => '5',
                'name' => 'Giáo trình chung',
                'parent_id' => '1',
            ],

            [
                'id' => '6',
                'name' => 'Tiếng anh VSTEP',
                'parent_id' => '1',
            ],

            [
                'id' => '7',
                'name' => 'Đề cương chung',
                'parent_id' => '1',
            ], 
            
            [
                'id' => '8',
                'name' => 'Đại học KHTN',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '9',
                'name' => 'Đại học KHXHNV',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '10',
                'name' => 'Đại học Ngoại Ngữ',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '11',
                'name' => 'Đại học Công Nghệ',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '12',
                'name' => 'Đại học Kinh Tế',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '13',
                'name' => 'Đại học Giáo Dục',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '14',
                'name' => 'Đại học Y Dược',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '15',
                'name' => 'Khoa Luật',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '16',
                'name' => 'Khoa Quốc Tế',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '17',
                'name' => 'Khoa QTKD',
                'parent_id' => '2',
            ], 
            
            [
                'id' => '18',
                'name' => 'Đề thi đánh giá năng lực',
                'parent_id' => '3',
            ], 
            
            [
                'id' => '19',
                'name' => 'Đề thi THPT Chuyên',
                'parent_id' => '3',
            ], 
        ]);
    }
}
