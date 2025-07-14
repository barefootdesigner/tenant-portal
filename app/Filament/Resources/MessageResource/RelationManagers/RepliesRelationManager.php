<?php

namespace App\Filament\Resources\MessageResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Form;

class MessageReplyRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static ?string $title = 'Replies';

public function form(Form $form): Form
{
    return $form->schema([
        Components\Textarea::make('message')
            ->label('Reply message')
            ->required()
            ->rows(3),
    ]);
}

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Date')->dateTime('d M Y H:i'),
                TextColumn::make('message')->limit(100)->wrap(),
                TextColumn::make('created_by')->label('Sent by')->formatStateUsing(fn ($record) =>
                    $record->creator?->name ?? 'Tenant'
                ),
            ])
            ->defaultSort('created_at', 'asc');
    }

public function mutateFormDataBeforeCreate(array $data): array
{
    $parent = $this->ownerRecord;

    $data['created_by'] = auth()->id();                // Admin ID
    $data['type'] = $parent->type;                     // Inherit type
    $data['reply_to_id'] = $parent->id;                // Link reply
    $data['user_id'] = $parent->user_id ?? $parent->created_by; // Send to tenant

    return $data;
}




}
