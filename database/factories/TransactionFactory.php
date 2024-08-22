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
    public function definition(): array
    {

        // Tentukan rentang tanggal

        return [
            'type_id' => random_int(1, 2),
            'amount' => fake()->numberBetween(10000, 35000),
            'member_id' => fake()->numberBetween(1, 20),
            'account_id' => fake()->numberBetween(1, 4),
            'website_id' => fake()->numberBetween(1, 4),
            'new' => fake()->boolean(40),
            'created_at' => fake()->dateTimeInInterval('-1 week', '+3 days'),

        ];
    }
}
