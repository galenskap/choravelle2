<?php

namespace App\Filament\Blocks;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Z3d0X\FilamentFabricator\Blocks\Block;

class AgendaRepertoireBlock extends Block
{
    public static function getBlockName(): string
    {
        return 'Agenda & Répertoire';
    }

    public static function getBlockSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Titre de la section')
                ->required(),
            RichEditor::make('agenda')
                ->label('Agenda')
                ->required(),
        ];
    }
} 