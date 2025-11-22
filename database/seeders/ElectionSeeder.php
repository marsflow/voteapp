<?php

namespace Database\Seeders;

use App\Enums\ElectionStatusEnum;
use App\Models\Candidate;
use App\Models\CandidateMember;
use App\Models\Committee;
use App\Models\Election;
use App\Models\Member;
use App\Models\Vote;
use App\Models\Voter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Carbon\Carbon;

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

        $elections = Election::factory()
            ->count(fake()->numberBetween(10, 15))
            ->has(
                Candidate::factory()
                    ->count(3)
                    ->has(
                        CandidateMember::factory()
                            ->count(2)
                    )
            )
            ->create()
            ;

        // get members without candidates
        $elections->each(function ($election) {
            $candidateIds = $election->candidates->pluck('id');
            $candidateMemberIds = $election->load('candidates.members')
                ->candidates
                ->flatMap
                ->members
                ->pluck('id');

            $members = Member::inRandomOrder()
                ->whereNotIn('id', $candidateMemberIds)
                ->limit(fake()->numberBetween(80, 120))
                ->get();

            // splice to commitees
            $memberWithoutCommitees = $members->splice(fake()->numberBetween(3, 5));

            // find head for commitees
            $head = $members->random();
            $commiteesIds = $members->keyBy('id')->map(fn () => null);
            $commiteesIds = $commiteesIds->map(fn () => ['is_head' => null]);
            $commiteesIds[$head->id] = ['is_head' => true];

            // insert committees
            $election->committees()->attach($commiteesIds->toArray());
            if ($election->status === ElectionStatusEnum::DRAFT) {
                $election->voters()
                    ->saveMany($memberWithoutCommitees->map(function ($member) use ($election) {
                        return new Voter([
                            'member_id' => $member->id,
                            'election_id' => $election->id,
                        ]);
                    }));
                return;
            }

            foreach ($memberWithoutCommitees as $member) {
                $voter = new Voter([
                    'election_id' => $election->id,
                    'member_id' => $member->id,
                ]);
                $voter->save();

                $chance = fake()->numberBetween(65, 95);
                if (fake()->numberBetween(1, 100) <= $chance) {
                    $createdAt = fake()->dateTimeBetween('-2 weeks', 'now');
                    $vote = new Vote([
                        'voter_id' => $voter->id,
                        'candidate_id' => $candidateIds->random(),
                        'created_at' => $createdAt,
                    ]);
                    $vote->save();
                }
            }
        });

    }
}
