<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'time' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'type' => $this->faker->randomElement(['expense', 'revenue']),
        ];
    }
}
