<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'phone_number' => fake()->phoneNumber(),
            'account_id' => fake()->numberBetween(1, 4),
            'website_id' => fake()->numberBetween(1, 4),
            'account_number' => '123456789',
            'total_wd' => fake()->numberBetween(10000, 200000),
            'total_depo' => fake()->numberBetween(10000, 200000),

        ];
    }
}
