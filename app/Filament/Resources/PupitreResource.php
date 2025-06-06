<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PupitreResource\Pages;
use App\Filament\Resources\PupitreResource\RelationManagers;
use App\Models\Pupitre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\HasTenantSelect;

class PupitreResource extends Resource
{
    use HasTenantSelect;

    protected static ?string $model = Pupitre::class;

    protected static ?string $navigationLabel = 'Pupitres';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Membres';

    protected static ?string $title = 'Pupitres';
    protected static ?string $pluralModelLabel = 'pupitres';
    protected static ?string $singularModelLabel = 'pupitre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getTenantFormField(),
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tenant.name')
                    ->label('Organisation')
                    ->searchable()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('tenant')
                    ->label('Organisation')
                    ->relationship('tenant', 'name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePupitres::route('/'),
        ];
    }
}
