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

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, CandidateMember::make()->getTable());
    }


}
