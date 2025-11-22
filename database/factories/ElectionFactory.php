<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use App\Enums\ElectionStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Election>
 */
class ElectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-2 weeks', '+1 weeks');
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'started_at' => $start,
            'ended_at' => Carbon::instance($start)->addWeek(),
            'status' => Arr::random(ElectionStatusEnum::cases()),
        ];
    }
}
