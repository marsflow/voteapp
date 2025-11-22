<?php

namespace App\Enums;

enum ElectionStatusEnum: string
{
    case DRAFT = '0';
    case PUBLISHED = '1';
    case COMPLETED = '2';
    case CANCELED = '3';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PUBLISHED   => 'Published',
            self::COMPLETED => 'Completed',
            self::CANCELED => 'Canceled',
        };
    }

    /** Used by Filament */
    // public static function options(): array
    // {
    //     return [
    //         self::FEMALE->value => self::FEMALE->label(),
    //         self::MALE->value   => self::MALE->label(),
    //     ];
    // }
}
