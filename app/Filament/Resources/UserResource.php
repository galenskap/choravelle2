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
use App\Filament\Traits\HasTenantSelect;

class UserResource extends Resource
{
    use HasTenantSelect;

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
                static::getTenantFormField(),
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
                    ->relationship(name: 'pupitre', titleAttribute: 'name'),
                Forms\Components\Select::make('roles')
                    ->label('Rôles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                Forms\Components\Checkbox::make('is_active')
                    ->label('Actif')
                    ->default(true),
                Forms\Components\Checkbox::make('email_notifications')
                    ->label('Activer les notifications par email')
                    ->default(true),
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
                TextColumn::make('roles.name')
                    ->label('Rôles')
                    ->formatStateUsing(function ($record) {
                        return $record->roles->pluck('name')->join(', ');
                    })
                    ->searchable(),
            ])
            ->filters([

                SelectFilter::make('tenant')
                    ->label('Organisation')
                    ->relationship('tenant', 'name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),

                SelectFilter::make('pupitre.name') 
                    ->label('Pupitre'),

                SelectFilter::make('is_active')
                    ->label('Actif')
                    ->options([
                        0 => 'Non',
                        1 => 'Oui',
                    ]),

                SelectFilter::make('roles')
                    ->label('Rôles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                SelectFilter::make('without_roles')
                    ->label('Sans rôle')
                    ->options([
                        'yes' => 'Utilisateurs sans rôle',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'yes',
                            fn (Builder $query): Builder => $query->doesntHave('roles'),
                        );
                    }),
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
