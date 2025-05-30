<?php

namespace App\Filament\Resources\BlockTemplateResource\Pages;

use App\Filament\Resources\BlockTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlockTemplates extends ListRecords
{
    protected static string $resource = BlockTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 