<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FolderResource\Pages;
use App\Filament\Resources\FolderResource\RelationManagers;
use App\Models\Folder;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Reactive;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\ReorderAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Reorder\ReorderOperation;

class FolderResource extends Resource
{
    protected static ?string $model = Folder::class;

    protected static ?string $navigationLabel = 'Saisons';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Partothèque';

    protected static ?string $title = 'Saisons';
    protected static ?string $pluralModelLabel = 'saisons';
    protected static ?string $singularModelLabel = 'saison';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Toggle::make('is_current')
                    ->label('Saison courante')
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state) {
                            // Désactiver is_current pour tous les autres dossiers
                            Folder::where('id', '!=', request()->route('record'))
                                ->update(['is_current' => false]);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                TextColumn::make('name')
                    ->label('Nom du classeur')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('songs_list')
                    ->label('Chansons')
                    ->state(function (Folder $record): string {
                        $songs = $record->songs()
                            ->orderBy('folder_song.order')
                            ->get();
                        
                        return $songs->map(function ($song) {
                            return "{$song->pivot->order}. {$song->title}<br/>";
                        })->join('');
                    })
                    ->html(),
                TextColumn::make('is_current')
                    ->label('Afficher sur la page d\'accueil')
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Oui' : 'Non'),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SongsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFolders::route('/'),
            'create' => Pages\CreateFolder::route('/create'),
            'edit' => Pages\EditFolder::route('/{record}/edit'),
        ];
    }
}
