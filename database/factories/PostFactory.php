<?php

namespace Database\Factories;

use App\Models\PostType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
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
            'title' => $this->faker->name(),
            'description' => $this->faker->colorName(),
            'content' => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            'post_type_id' => PostType::pluck('id')->random(),
            'status' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
