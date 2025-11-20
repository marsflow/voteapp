<?php

namespace App\Enums;

enum GenderEnum: string
{
    case FEMALE = 'f';
    case MALE = 'm';

    public function label(): string
    {
        return match ($this) {
            self::FEMALE => 'Female',
            self::MALE   => 'Male',
        };
    }

    /** Used by Filament */
    public static function options(): array
    {
        return [
            self::FEMALE->value => self::FEMALE->label(),
            self::MALE->value   => self::MALE->label(),
        ];
    }
}
