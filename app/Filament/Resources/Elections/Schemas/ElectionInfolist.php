<?php

namespace App\Filament\Resources\Elections\Schemas;

use App\Models\Candidate;
use App\Models\Election;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\RepeatableEntry\TableColumn;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Infolists\Components\IconEntry;
use Carbon\Carbon;

class ElectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
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
                Section::make('Commmitees')
                    ->schema([
                        RepeatableEntry::make('committee_members')
                            ->table([
                                TableColumn::make('Full Name'),
                                TableColumn::make('Head'),
                            ])
                            ->schema([
                                TextEntry::make('full_name'),
                                IconEntry::make('pivot.is_head')
                                    ->boolean(),
                            ])
                    ])
                    ->columnSpanFull(),
                Section::make('Candidates')
                    ->schema([
                        RepeatableEntry::make('candidates')
                            ->state(function (Election $record) {
                                return $record
                                    ->load([
                                        'candidates' => function ($candidate) {
                                            return $candidate
                                                ->orderBy('order')
                                                ->withCount('votes');
                                        },
                                    ])
                                    ->candidates;
                            })
                            ->table([
                                TableColumn::make('Order'),
                                TableColumn::make('Title'),
                                TableColumn::make('#Votes'),
                            ])
                            ->schema([
                                TextEntry::make('order'),
                                TextEntry::make('title'),
                                TextEntry::make('votes_count'),
                            ])
                    ])
                    ->columnSpanFull(),
                Section::make('Eligible Voters')
                    ->schema([
                        RepeatableEntry::make('voters')
                            ->state(function (Election $record) {
                                return $record
                                    ->load(['voters.vote'])
                                    ->voters
                                    ->sortByDesc(function ($voter) {
                                        return $voter?->vote?->created_at;
                                    })
                                    ;
                            })
                            ->table([
                                TableColumn::make('Name'),
                                TableColumn::make('Vote At'),
                            ])
                            ->schema([
                                TextEntry::make('member.full_name'),
                                TextEntry::make('vote.created_at')
                                    ->formatStateUsing(function ($record) {
                                        return Carbon::instance($record->vote->created_at)->diffForHumans();
                                    }),
                            ])
                    ])
                    ->columnSpanFull()
            ]);
    }
}
