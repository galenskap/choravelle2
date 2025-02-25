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

class SongResource extends Resource
{
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
                TextInput::make('title')
                    ->label('Titre')
                    ->required(),
                TextInput::make('author')
                    ->label('Auteur'),
                RichEditor::make('lyrics')
                    ->label('Paroles')
                    ->required(),
                RichEditor::make('comment')
                    ->label('Commentaire'),
                Toggle::make('show_on_home')
                    ->label('Afficher sur la page d\'accueil')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('author')
                    ->label('Auteur')
                    ->searchable()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated(25);
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
            ->with('files')
            ->withMax('files', 'updated_at')
            ->orderByRaw('CASE 
                WHEN files_max_updated_at IS NULL OR songs.updated_at > files_max_updated_at 
                THEN songs.updated_at 
                ELSE files_max_updated_at 
            END DESC');
    }
}
