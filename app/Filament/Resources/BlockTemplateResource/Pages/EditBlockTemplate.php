<?php

namespace App\Filament\Resources\BlockTemplateResource\Pages;

use App\Filament\Resources\BlockTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlockTemplate extends EditRecord
{
    protected static string $resource = BlockTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 