<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockTemplateResource\Pages;
use App\Models\BlockTemplate;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlockTemplateResource extends Resource
{
    protected static ?string $model = BlockTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Site public';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('Template name'))
                    ->required(),
                TextInput::make('slug')
                    ->label(__('Unique identifier'))
                    ->required()
                    ->unique(ignoreRecord: true),
                FileUpload::make('preview_image')
                    ->label(__('Preview image'))
                    ->image()
                    ->directory('block-templates'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('preview_image'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlockTemplates::route('/'),
            'create' => Pages\CreateBlockTemplate::route('/create'),
            'edit' => Pages\EditBlockTemplate::route('/{record}/edit'),
        ];
    }
} 