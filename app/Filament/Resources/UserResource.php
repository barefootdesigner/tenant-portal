<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput; // <-- THIS GOES HERE
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Spatie\Permission\Models\Role;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
           
           
           Select::make('roles')
    ->label('Role')
    ->relationship('roles', 'name')
    ->multiple()
    ->preload()
    ->required(),

           
           
           
           
                    TextInput::make('password')
    ->password()
    ->maxLength(255)
    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
    ->dehydrated(fn ($state) => filled($state)) // only include in save if not blank
    ->required(fn ($context) => $context === 'create'),

                    TextInput::make('phone')
    ->label('Phone Number')
    ->maxLength(20),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
    Tables\Columns\TextColumn::make('name')->searchable(),
    Tables\Columns\TextColumn::make('email')->searchable(),
    Tables\Columns\TextColumn::make('phone')->label('Phone Number'),
Tables\Columns\TagsColumn::make('roles.name')->label('Roles'),

    Tables\Columns\TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
])

            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
