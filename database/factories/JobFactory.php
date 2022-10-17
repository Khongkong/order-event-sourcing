<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => fake()->numberBetween(1, 99999),
            'name' => fake()->jobTitle(),
            'company_id' => fake()->numberBetween(1, 99999),
            'description' => fake()->text(),
        ];
    }
}
