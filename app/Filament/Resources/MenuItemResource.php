<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Site public';

    protected static ?string $navigationLabel = 'Menu principal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('route_name')
                    ->label('Page')
                    ->options(function() {
                        // Static routes
                        // NOTE: add any new static route created here
                        $staticRoutes = [
                            'agenda' => 'Agenda',
                            'agenda-archives' => 'Événements passés',
                            'repertoire' => 'Répertoire',
                        ];
                        
                        // CMS (dynamic) pages
                        $dynamicPages = Page::where('is_published', true)
                            ->get()
                            ->mapWithKeys(function ($page) {
                                $title = $page->title['fr'] 
                                    ?? ($page->title ?: $page->slug);
                                return ['page.show/' . $page->slug => $title];
                            })
                            ->toArray();
                        
                        return $staticRoutes + $dynamicPages;
                    })
                    ->helperText('Laissez vide si vous utilisez une URL personnalisée')
                    ->searchable(),
                Forms\Components\TextInput::make('url')
                    ->label('URL')
                    ->helperText('Laissez vide si vous sélectionnez une page'),
                Forms\Components\TextInput::make('title')
                    ->label('Texte du lien')
                    ->required(),
                Forms\Components\TextInput::make('order')
                    ->label('Ordre')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Actif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Titre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('route_name')
                    ->label('Nom de la route...'),
                Tables\Columns\TextColumn::make('url')
                    ->label('...ou URL')
                    ->getStateUsing(fn ($record) => $record->getRawOriginal('url')),
                Tables\Columns\TextColumn::make('order')
                    ->label('Ordre')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
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
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
} 