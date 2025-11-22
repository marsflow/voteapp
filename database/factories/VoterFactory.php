<?php

namespace Database\Factories;

use App\Models\Candidate;
use App\Models\Election;
use App\Models\Member;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voter>
 */
class VoterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'election_id' => Election::factory(),
            'member_id' => Member::factory(),
        ];
    }
}
