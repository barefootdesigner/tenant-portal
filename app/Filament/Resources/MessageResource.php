<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageResource\Pages;
use App\Filament\Resources\MessageResource\RelationManagers;
use App\Models\Message;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

class MessageResource extends Resource
{
    protected static ?string $model = Message::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
         return $form->schema([
        Select::make('type')
            ->required()
            ->options([
                'Issue' => 'Issue',
                'Parcel' => 'Parcel',
                'Notice' => 'Notice',
                'Alert' => 'Alert',
            ]),
        TextInput::make('subject')->maxLength(255),
        Textarea::make('message')->rows(5),
        Select::make('status')
            ->options([
                'Open' => 'Open',
                'Resolved' => 'Resolved',
                'Collected' => 'Collected',
                'Closed' => 'Closed',
            ]),
        Select::make('user_id')
            ->relationship('user', 'name')
            ->searchable()
            ->label('Send to User'),
        Select::make('business_id')
            ->relationship('business', 'name')
            ->searchable()
            ->label('Send to Business'),
        Toggle::make('is_global')->label('Send to Everyone'),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('type')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Issue' => 'danger',
                    'Parcel' => 'warning',
                    'Notice' => 'info',
                    'Alert' => 'gray',
                    default => 'secondary',
                }),
            TextColumn::make('subject')->limit(50)->sortable()->searchable(),
            TextColumn::make('user.name')->label('User')->sortable()->searchable(),
            TextColumn::make('business.name')->label('Business')->sortable()->searchable(),
            IconColumn::make('is_global')
                ->label('Global')
                ->boolean(),
            BadgeColumn::make('status')
                ->colors([
                    'primary' => 'Open',
                    'success' => 'Resolved',
                    'info' => 'Collected',
                    'gray' => 'Closed',
                ])
                ->sortable(),
            TextColumn::make('created_at')
                ->dateTime('d M Y H:i')
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [


            //
        ];
    }


    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->whereNull('reply_to_id'); // Show only top-level messages
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessages::route('/'),
            'create' => Pages\CreateMessage::route('/create'),
            'edit' => Pages\EditMessage::route('/{record}/edit'),
        ];
    }
}
