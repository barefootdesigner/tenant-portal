<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PollResource\Pages;
use App\Models\Poll;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PollResource extends Resource
{
protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

 public static function form(Form $form): Form
{
    return $form
            ->columns(1) // <--- add this line!

        ->schema([
            TextInput::make('question')
                ->required()
                ->label('Poll Question'),
            Repeater::make('options')
                ->label('Poll Options')
                ->schema([
                    TextInput::make('text')->label('Option')->required(),
                ])
                ->minItems(2)
                ->maxItems(10)
                ->required(),
            Forms\Components\Select::make('status')
                ->options([
                    'open' => 'Open',
                    'closed' => 'Closed',
                ])
                ->required()
                ->default('open')
                ->label('Status'),
     Forms\Components\View::make('filament.poll-results')
    ->visible(fn ($livewire) => $livewire->getRecord() !== null)
  ->viewData(function ($livewire) {
    return [
        'record' => $livewire->getRecord(),
    ];
}),
        ]); // <--- This closes the .schema([ ... ]) array
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->label('Question')->searchable(),
                TextColumn::make('status')->label('Status')->badge(),
                TextColumn::make('created_at')->dateTime('d/m/Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPolls::route('/'),
            'create' => Pages\CreatePoll::route('/create'),
            'edit' => Pages\EditPoll::route('/{record}/edit'),
        ];
    }
}
