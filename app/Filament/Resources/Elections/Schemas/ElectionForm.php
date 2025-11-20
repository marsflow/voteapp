<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ElectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('ended_at')
                    ->required(),
                TextInput::make('status')
                    ->required(),
            ]);
    }
}
