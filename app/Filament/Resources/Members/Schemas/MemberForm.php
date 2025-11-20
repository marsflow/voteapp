<?php

namespace App\Filament\Resources\Members\Schemas;

use App\Enums\GenderEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Radio::make('gender')
                    ->options(GenderEnum::options())
                    ->required(),
                DatePicker::make('born_date')
                    ->required(),
                DatePicker::make('joined_at')
                    ->required(),
                TextInput::make('address')
                    ->required(),
            ]);
    }
}
