<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => User::factory(),
            'status_id' => 1,
            'category_id' => random_int(1, 8),
            'city_id' => random_int(1, 100),
            'title' => fake()->title,
            'description' => fake()->text,
            'address' => fake()->address,
            'budget' => random_int(1000, 10000),
            'expiration_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
