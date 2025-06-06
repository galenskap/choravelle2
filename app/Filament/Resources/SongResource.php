<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SongResource\Pages;
use App\Filament\Resources\SongResource\RelationManagers;
use App\Models\Song;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Traits\HasTenantSelect;

class SongResource extends Resource
{
    use HasTenantSelect;

    protected static ?string $model = Song::class;

    protected static ?string $navigationLabel = 'Chants';
    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    
    protected static ?string $navigationGroup = 'Partothèque';

    protected static ?string $title = 'Chants';
    protected static ?string $pluralModelLabel = 'chants';
    protected static ?string $singularModelLabel = 'chant';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                static::getTenantFormField(),
                TextInput::make('title')
                    ->label('Titre')
                    ->required(),
                TextInput::make('author')
                    ->label('Auteur'),
                Select::make('folders')
                    ->label('Saisons')
                    ->multiple()
                    ->relationship('folders', 'name')
                    ->preload(),
                Toggle::make('show_on_home')
                    ->label('Afficher sur la page d\'accueil')
                    ->default(false),
                RichEditor::make('lyrics')
                    ->label('Paroles'),
                RichEditor::make('comment')
                    ->label('Commentaire'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('tenant.name')
                    ->label('Organisation')
                    ->searchable()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('folders.name')
                    ->label('Saisons')
                    ->listWithLineBreaks()
                    ->bulleted(),
                TextColumn::make('files')
                    ->label('Fichiers')
                    ->getStateUsing(function ($record) {
                        return $record->files->map(function ($file) {
                            return $file->title ?: basename($file->filename);
                        });
                    })
                    ->listWithLineBreaks()
                    ->bulleted(),
            ])
            ->filters([
                SelectFilter::make('tenant')
                    ->label('Organisation')
                    ->relationship('tenant', 'name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                SelectFilter::make('folder')
                    ->label('Saison')
                    ->relationship('folders', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FilesRelationManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSongs::route('/'),
            'create' => Pages\CreateSong::route('/create'),
            'edit' => Pages\EditSong::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::withMax('files', 'updated_at')
            ->orderByDesc('updated_at')
            ->orderByDesc('files_max_updated_at')
            ->count();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['files', 'folders'])
            ->withMax('files', 'updated_at')
            ->orderByRaw('CASE 
                WHEN files_max_updated_at IS NULL OR songs.updated_at > files_max_updated_at 
                THEN songs.updated_at 
                ELSE files_max_updated_at 
            END DESC');
    }
}
