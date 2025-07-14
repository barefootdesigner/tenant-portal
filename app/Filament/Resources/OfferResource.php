<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Offers & Events';

   public static function canViewAny(): bool
{
    return true;
}

public static function canView(Model $record): bool
{
    return true;
}

public static function canCreate(): bool
{
    return true;
}

public static function canEdit(Model $record): bool
{
    return true;
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('headline')->required(),
                Textarea::make('body')->required(),

                FileUpload::make('image')
                    ->image()
                    ->directory('offer-images')
                    ->visibility('public')
                    ->preserveFilenames(),

                Select::make('category')
                    ->options([
                        'food' => 'Food & Drink',
                        'social' => 'Social & Events',
                        'fitness' => 'Fitness & Wellness',
                    ])
                    ->nullable()
                    ->searchable(),

                DatePicker::make('start_date')->required(),
                DatePicker::make('end_date')->required(),

                Toggle::make('published')
                    ->default(true)
                    ->label('Published?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('headline')->searchable()->sortable(),
                TextColumn::make('category')->sortable(),
                ImageColumn::make('image')->circular(),
                TextColumn::make('start_date')->date()->label('Start'),
                TextColumn::make('end_date')->date()->label('End'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                // You can add filters later for Active/Expired/etc
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }


}
