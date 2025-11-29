<?php

namespace App\Filament\Resources\Elections\Schemas;

use App\Models\Member;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;

use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
class ElectionForm
{
    protected static int $order = 0;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Election Detail')
                        ->schema([
                            TextInput::make('title')
                                ->required(),
                            RichEditor::make('description')
                                ->required()
                                ->columnSpanFull(),
                            DateTimePicker::make('started_at')
                                ->required()
                                ->columns(1),
                            DateTimePicker::make('ended_at')
                                ->required()
                                ->after('started_at')
                                ->columns(1),
                        ]),

                    Step::make('Candidates')
                        ->schema([
                            Repeater::make('candidates')
                                ->relationship('candidates')
                                ->schema([
                                    Hidden::make('order'),
                                    TextInput::make('title')
                                        ->required(),
                                    RichEditor::make('description')
                                        ->required()
                                        ->columnSpanFull(),
                                    Select::make('member_id')
                                        ->label('Members')
                                        ->required()
                                        ->multiple()
                                        ->searchable()
                                        ->searchDebounce(500)
                                        ->getOptionLabelsUsing(function ($values) {
                                            return Member::whereIn('id', $values)
                                                ->get()
                                                ->pluck('full_name', 'id')
                                                ->toArray();
                                        })
                                        ->getSearchResultsUsing(function (string $search) {
                                            return Member::query()
                                                ->where(function ($query) use ($search) {
                                                    $query->where('first_name', 'ilike', "%{$search}%")
                                                        ->orWhere('last_name', 'ilike', "%{$search}%");
                                                })
                                                ->limit(10)
                                                ->get()
                                                ->pluck('full_name', 'id');
                                        })
                                ])
                                // handle order
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                    $data['order'] = ++self::$order;
                                    return $data;
                                })
                                ->defaultItems(2),
                        ]),

                    Step::make('Committees')
                        ->schema([
                            Repeater::make('committees')
                                ->relationship('committees')
                                ->schema([
                                    Select::make('member_id')
                                        ->required()
                                        ->searchable()
                                        ->searchDebounce(500)
                                        ->getSearchResultsUsing(function (string $search) {
                                            return Member::query()
                                                ->where(function ($query) use ($search) {
                                                    $query->where('first_name', 'ilike', "%{$search}%")
                                                        ->orWhere('last_name', 'ilike', "%{$search}%");
                                                })
                                                ->limit(10)
                                                ->get()
                                                ->pluck('full_name', 'id');
                                        })
                                        ->getOptionLabelUsing(fn ($value) => Member::find($value)?->full_name),
                                    Checkbox::make('is_head')
                                        ->inline(),
                                ])
                                // ->defaultItems(2),
                        ]),

                ])
                // Section::make('Election Detail')

                //     ->columns(2)
                //     ->columnSpanFull(),
                // Section::make('Candidates')

                //     ->columnSpanFull()
            ]);
    }
}
