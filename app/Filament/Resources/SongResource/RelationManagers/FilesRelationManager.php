<?php

namespace App\Filament\Resources\SongResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FilesRelationManager extends RelationManager
{
    protected static string $relationship = 'files';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required(),
                Forms\Components\FileUpload::make('filename')
                    ->label('Fichier')
                    ->required()
                    ->disk('public'),
                Forms\Components\Select::make('pupitres')
                    ->label('Pupitres')
                    ->multiple()
                    ->relationship('pupitres', 'name')
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre'),
                Tables\Columns\TextColumn::make('filename')
                    ->label('Nom du fichier'),
                Tables\Columns\TextColumn::make('pupitre.name')
                    ->label('Pupitre'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}