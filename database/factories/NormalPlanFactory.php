<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NormalPlan>
 */
class NormalPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->numberBetween(1, 99999),
            'description' => fake()->text(),
            'price' => fake()->numberBetween(1000, 3000),
            'base_plan_id' => fake()->numberBetween(1, 99999),
            'extra_bonus' => fake()->shuffleArray([
                'nani',
                'nanananani',
            ]),
        ];
    }
}
