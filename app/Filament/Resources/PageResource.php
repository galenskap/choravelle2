<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers\BlocksRelationManager;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Traits\HasTenantSelect;

class PageResource extends Resource
{
    use HasTenantSelect;

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Site public';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(12)
                    ->schema([
                        static::getTenantFormField(),
                        TextInput::make('title')
                            ->label(__('Page title'))
                            ->columnSpan(6)
                            ->required(),
                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->columnSpan(6)
                            ->required(),
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->columnSpanFull(),
                        Checkbox::make('is_published')
                            ->label(__('Published')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tenant.name')
                    ->label('Organisation')
                    ->searchable()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record) => route('page.show', $record->slug)),
                Tables\Columns\IconColumn::make('is_published')
                    ->icon('heroicon-c-document-magnifying-glass')
                    ->label('Published'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tenant')
                    ->label('Organisation')
                    ->relationship('tenant', 'name')
                    ->multiple()
                    ->preload()
                    ->visible(fn () => auth()->user()->hasRole('super_admin')),
                Tables\Filters\SelectFilter::make('is_published')
                    ->options([
                        1 => 'Publié',
                        0 => 'Brouillon',
                    ])
                    ->label('Statut'),
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
            BlocksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
