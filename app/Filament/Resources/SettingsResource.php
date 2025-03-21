<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\File;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Configuration';

    protected static ?string $navigationLabel = 'Apparence';

    public static function form(Form $form): Form
    {
        $themes = collect(File::files(resource_path('css/themes')))
            ->map(fn($file) => $file->getFilenameWithoutExtension())
            ->flip()
            ->map(fn($i, $theme) => ucfirst($theme))
            ->toArray();

        return $form
            ->schema([
                Forms\Components\Select::make('theme')
                    ->label('Thème')
                    ->options($themes)
                    ->required(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSettings::route('/'),
        ];
    }
} 