<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostReportFactory extends Factory
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
            'description' => $this->faker->colorName(),
            'post_id' => Post::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'resolve' => $this->faker->numberBetween(1,2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
