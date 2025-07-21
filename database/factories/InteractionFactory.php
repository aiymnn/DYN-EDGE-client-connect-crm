<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'datetime' => fake()->dateTimeBetween('-2 months', 'now'),
            'type' => fake()->randomElement(['call', 'email', 'meeting']),
            'notes' => fake()->paragraph(),
        ];
    }
}
