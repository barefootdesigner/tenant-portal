<?php

namespace App\Filament\Resources;
use Filament\Forms\Components\Select;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Models\Business;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\View;




class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

 public static function form(Form $form): Form
{
    return $form
        ->schema([
            FileUpload::make('logo')
                ->label('Logo')
                ->image()
                ->directory('business-logos')
                ->disk('public')
                ->imagePreviewHeight('100'),
            TextInput::make('name')
                ->label('Business Name')
                ->required()
                ->maxLength(255),
            Textarea::make('overview')
                ->label('Overview')
                ->rows(3)
                ->maxLength(500),
            TextInput::make('location')
                ->label('Location in Building')
                ->maxLength(255),
View::make('business.tenants-list')
    ->label('Tenants')
    ->columnSpanFull(),

        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('logo')
                ->label('Logo')
                ->circular()
                ->size(40),
            TextColumn::make('name')->label('Business Name')->searchable()->sortable(),
            TextColumn::make('location')->label('Location')->sortable(),
            TextColumn::make('overview')->label('Overview')->limit(30),
            TextColumn::make('created_at')->label('Created')->dateTime('d/m/Y H:i')->sortable(),
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
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
