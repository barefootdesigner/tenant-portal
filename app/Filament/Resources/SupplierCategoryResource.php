<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierCategoryResource\Pages;
use App\Filament\Resources\SupplierCategoryResource\RelationManagers;
use App\Models\SupplierCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;



class SupplierCategoryResource extends Resource
{
    protected static ?string $model = SupplierCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')->required(),
            Textarea::make('description')->rows(2),
        ]);
    }

public static function table(Table $table): Table
{
    return $table
    ->columns([
        TextColumn::make('id')->sortable(),
        TextColumn::make('name')->sortable()->searchable(),
        TextColumn::make('description')->limit(40),
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
            'index' => Pages\ListSupplierCategories::route('/'),
            'create' => Pages\CreateSupplierCategory::route('/create'),
            'edit' => Pages\EditSupplierCategory::route('/{record}/edit'),
        ];
    }
}
