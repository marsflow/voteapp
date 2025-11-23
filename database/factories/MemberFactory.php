<?php

namespace Database\Factories;

use App\Models\User;
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
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'gender' => fake()->randomElement(['m', 'f']),
            'born_date' => fake()->dateTimeBetween('-70 years', '-18 years'),
            'address' => fake()->address(),
            'joined_at' => fake()->dateTimeBetween(),
            'user_id' => User::factory(),
        ];
    }
}
