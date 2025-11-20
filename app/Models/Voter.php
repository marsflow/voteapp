<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
