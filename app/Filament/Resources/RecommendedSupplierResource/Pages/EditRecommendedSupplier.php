<?php

namespace App\Filament\Resources\RecommendedSupplierResource\Pages;

use App\Filament\Resources\RecommendedSupplierResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecommendedSupplier extends EditRecord
{
    protected static string $resource = RecommendedSupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
