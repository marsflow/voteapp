<?php

namespace App\Filament\Resources\Elections\Schemas;

use App\Models\Election;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\IconEntry;

class ElectionInfolist
{
    public static function configure(Schema $schema): Schema
    {

        $elections = Election::with(['committees', 'candidates.members', 'voters'])->get();
        dd($elections->toArray());
        return $schema
            ->components([
                Section::make('Election Detail')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('description')
                            ->columnSpanFull(),
                        TextEntry::make('started_at')
                            ->dateTime(),
                        TextEntry::make('ended_at')
                            ->dateTime(),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->formatStateUsing((fn($record) => $record->status->label())),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
                Section::make('Commitees')
                    ->schema([
                        RepeatableEntry::make('committees')
                            ->table([
                                TableColumn::make('Full Name'),
                                TableColumn::make('Head'),
                            ])
                            ->schema([
                                TextEntry::make('full_name'),
                                IconEntry::make('is_head')
                                    ->boolean(),
                            ])
                    ])
                    ->columnSpanFull(),
                Section::make('Candidates')
                    ->schema([
                        RepeatableEntry::make('candidates')
                            ->table([
                                TableColumn::make('Order'),
                                TableColumn::make('Title'),
                            ])
                            ->schema([
                                TextEntry::make('order'),
                                TextEntry::make('title'),
                            ])
                    ])
                    ->columnSpanFull(),
                Section::make('Eligible Voters')
                    ->schema([
                        RepeatableEntry::make('voters')
                            ->table([
                                TableColumn::make('Order'),
                                TableColumn::make('Title'),
                            ])
                            ->schema([
                                TextEntry::make('order'),
                                TextEntry::make('title'),
                            ])
                    ])
                    ->columnSpanFull()
            ]);
    }
}
