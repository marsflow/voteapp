<?php

namespace App\Models;

use App\Enums\ElectionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    /** @use HasFactory<\Database\Factories\ElectionFactory> */
    use HasFactory;

    protected $casts = [
        'status' => ElectionStatusEnum::class,
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function voters()
    {
        return $this->hasMany(Voter::class)
            ;
    }

    public function committees()
    {
        return $this->belongsToMany(Member::class, Committee::make()->getTable());
    }
}
