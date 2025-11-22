<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\CandidateMember;
use App\Models\Committee;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;


class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $order = 1;

        Vote::truncate();
        Voter::truncate();
        CandidateMember::truncate();
        Candidate::truncate();
        Committee::truncate();
        Election::truncate();

        Election::factory()
            ->count(fake()->numberBetween(5, 10))
            ->has(
                Candidate::factory()
                    ->count(3)
                    ->has(
                        CandidateMember::factory()
                            ->count(2)
                    )
            )
            ->has(
                Committee::factory()
                    ->count(5)
            )
            ->has(
                Voter::factory()
                    ->count(100)
                    ->has(Vote::factory())
            )
            ->create()
            ;

    }
}
