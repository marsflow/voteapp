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

    public function withVote()
    {
        // $chance = fake()->numberBetween(65, 95);
        return $this->state(function () {
            return [];
        })
        ->afterCreating(function (Voter $voter) {
            $chance = fake()->numberBetween(65, 95);
            if (fake()->numberBetween(1, 100) <= $chance) {
                $voter->vote()
                    ->save(new Vote([
                        'voter_id' => $voter->id,
                        'candidate_id' => $voter->election->candidates->random()->id,
                    ]));
            }
        })
        ;
    }
}
