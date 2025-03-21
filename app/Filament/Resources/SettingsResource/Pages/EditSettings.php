<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSettings extends EditRecord
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function mount(string|int $record = null): void
    {
        $settings = \App\Models\Settings::first() ?? \App\Models\Settings::create(['theme' => 'default']);
        $this->record = $settings;
        $this->form->fill($this->record->attributesToArray());
    }
} 