<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Radio;

class MemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_name'),
                TextEntry::make('last_name'),
                TextEntry::make('phone'),
                TextEntry::make('gender')
                    ->formatStateUsing((fn($record) => $record->gender->label())),
                TextEntry::make('born_date')
                    ->date(),
                TextEntry::make('joined_at')
                    ->date(),
                TextEntry::make('address'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
