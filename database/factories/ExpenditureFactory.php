<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expenditure>
 */
class ExpenditureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => fake()->numberBetween(2, 3),
            'amount' => fake()->numberBetween(60000, 100000),
            'detail' => fake()->sentence(4),
            'account_id' => fake()->numberBetween(1, 5),
            'website_id' => fake()->numberBetween(1, 4),
            'currency_id' => fake()->numberBetween(1, 4),

        ];
    }
}
