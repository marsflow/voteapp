<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateMember extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
