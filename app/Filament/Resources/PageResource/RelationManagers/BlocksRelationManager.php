<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DetachBulkAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Contracts\HasRelationshipTable;

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('order')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('template'),
                TextColumn::make('order'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\TextInput::make('order')
                            ->label('Order')
                            ->required()
                            ->default(0),
                    ])
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make()
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                ]),
            ]);
    }
}
