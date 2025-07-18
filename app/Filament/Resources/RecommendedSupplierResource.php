<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecommendedSupplierResource\Pages;
use App\Filament\Resources\RecommendedSupplierResource\RelationManagers;
use App\Models\RecommendedSupplier;
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
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;



class RecommendedSupplierResource extends Resource
{
    protected static ?string $model = RecommendedSupplier::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')->required(),
            Textarea::make('description')->rows(3),
            TextInput::make('website')->url(),
            FileUpload::make('logo_path')->directory('supplier-logos'),
            Select::make('supplier_category_id')
                ->label('Category')
                ->relationship('supplierCategory', 'name')
                ->searchable()
                ->nullable(),
        ]);
}


   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('website')->limit(30),
            TextColumn::make('supplierCategory.name')->label('Category'),
            ImageColumn::make('logo_path')->disk('public'),
        ])
        ->filters([
            // Add filters here if needed
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

    public function supplierCategory()
{
    return $this->belongsTo(SupplierCategory::class);
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecommendedSuppliers::route('/'),
            'create' => Pages\CreateRecommendedSupplier::route('/create'),
            'edit' => Pages\EditRecommendedSupplier::route('/{record}/edit'),
        ];
    }
}
