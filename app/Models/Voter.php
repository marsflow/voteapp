<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Relations\Pivot;

class Voter extends Model
{
    use HasFactory;

    public function vote()
    {
        return $this->hasOne(Vote::class);
    }

    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
