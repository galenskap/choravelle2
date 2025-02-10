<?php

namespace App\Filament\Resources\PupitreResource\Pages;

use App\Filament\Resources\PupitreResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePupitres extends ManageRecords
{
    protected static string $resource = PupitreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
