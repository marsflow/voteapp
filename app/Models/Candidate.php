<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidate extends Model
{
    use HasFactory;

    public function candidateMembers()
    {
        return $this->hasMany(CandidateMember::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'candidate_members')
            ->using(CandidateMember::class);
    }


}
