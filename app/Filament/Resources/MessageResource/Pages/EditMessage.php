<?php

namespace App\Filament\Resources\MessageResource\Pages;

use App\Filament\Resources\MessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMessage extends EditRecord
{
    protected static string $resource = MessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }


// In app/Filament/Resources/MessageResource/Pages/EditMessage.php

public function getFooter(): ?\Illuminate\View\View
{
    return view('filament.admin.messages._thread', ['message' => $this->record->load('replies')]);
}



}
