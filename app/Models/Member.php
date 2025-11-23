<?php

namespace App\Models;

use App\Enums\GenderEnum;
use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// #[UseFactory(MemberFactory::class)]
class Member extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'gender',
        'born_date',
        'address',
        'joined_at',
    ];

    protected $casts = [
        'gender' => GenderEnum::class,
    ];

    public function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->first_name . ' ' . $this->last_name
        );
    }

    public function elections()
    {
        return $this->belongsToMany(Election::class)
            ->using(Voter::class)
            ;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
