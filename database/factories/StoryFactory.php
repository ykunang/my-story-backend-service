<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Story>
 */
class StoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'category_id' => random_int(1, 4),
            'title' => fake()->title(),
            'description' => fake()->text(100),
            'photo' => fake()->image(dir: storage_path('app/public/stories'), width:250, height:250, fullPath:false),
        ];
    }
}
