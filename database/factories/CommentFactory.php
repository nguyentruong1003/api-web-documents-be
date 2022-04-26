<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'comment' => $this->faker->name(),
            'post_id' => Post::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
