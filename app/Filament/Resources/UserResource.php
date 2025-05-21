<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Membres';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Membres';

    protected static ?string $title = 'Inscrits';
    protected static ?string $pluralModelLabel = 'membres';
    protected static ?string $singularModelLabel = 'membre';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Mot de passe')
                    ->password()
                    ->hiddenOn('edit')
                    ->required(),
                Forms\Components\FileUpload::make('profile_photo_path')
                    ->label('Photo de profil')
                    ->image()    
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                    ])
                    ->circleCropper()
                    ->avatar()
                    ->disk('public'),
                Forms\Components\Select::make('pupitre_id')
                    ->label('Pupitre')
                    ->relationship(name: 'pupitre', titleAttribute: 'name')
                    ->required(),
                Forms\Components\Checkbox::make('is_active')
                    ->label('Actif')
                    ->default(true),
                Forms\Components\Checkbox::make('is_admin')
                    ->label('Administrateur'),
                Forms\Components\Checkbox::make('email_notifications')
                    ->label('Activer les notifications par email')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultPaginationPageOption(25)
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('profile_photo_path')
                    ->label('Photo'),
                TextColumn::make('pupitre.name')
                    ->label('Pupitre')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Actif')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_admin')
                    ->label('Administrateur')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('pupitre.name') 
                    ->label('Pupitre'),

                SelectFilter::make('is_active')
                    ->label('Actif')
                    ->options([
                        0 => 'Non',
                        1 => 'Oui',
                    ]),

                SelectFilter::make('is_admin')
                    ->label('Administrateur')
                    ->options([
                        0 => 'Non',
                        1 => 'Oui',
                    ]),
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

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
